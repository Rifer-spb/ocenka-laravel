<?php

namespace App\Core\Entities\Notary;

use App\Core\Entities\AbstractEntity;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\NationalPhone;
use App\Core\ValueObjects\Site;
use Database\Factories\Core\Entities\Notary\NotaryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $notariat_notary_id id нотариуса во внешнем сервисе notariat.ru
 * @property int $region_id id региона
 * @property string $name фио нотариуса
 * @property string $address адрес нотариуса
 * @property string|null $site сайт нотариуса
 * @property bool $is_work действует ли нотариус или нет
 * @property string|null $comment произвольный комментарий
 * @property null|bool $use_digital_report принимает ли электронный отчет или нет
 * @property int $count_orders кол-во всех существующих заказов связанных с этим нотариусом
 * @property int $count_year_orders кол-во всех существующих заказов в текущем году. Каждый год сбрасывается
 * @property null|int $user_id привязанный пользователь в системе
 *
 * @property NotaryRegion $region
 * @property Collection|NotaryPhone[] $phones
 * @property Collection|NotaryEmail[] $emails
 *
 * @method static NotaryFactory factory
 */
class Notary extends AbstractEntity
{
    protected $table = 'notaries';

    /**
     * @param NotariatId $notariatId
     * @param NotaryRegion $region
     * @param string $name
     * @param string $address
     * @param array $phones
     * @return self
     * @throws \Throwable
     * @see \Tests\Unit\Core\Models\Notary\CreateTest
     */
    public static function createNew(NotariatId $notariatId, NotaryRegion $region, string $name, string $address, array $phones): self
    {
        $notary = new self();
        $notary->notariat_notary_id = $notariatId->getValue();
        $notary->region_id = $region->id;
        $notary->name = $name;
        $notary->address = $address;
        $notary->saveOrFail();

        foreach ($phones as $phone) {
            $notary->addPhone($phone);
        }

        return $notary;
    }

    /**
     * @param int|string $phone
     * @return bool
     * @see \Tests\Unit\Core\Models\Notary\HasPhoneTest
     */
    public function hasPhone(int|string $phone): bool
    {
        return $this->phones->contains('phone', $phone);
    }

    /**
     * @param string $email
     * @return bool
     * @see \Tests\Unit\Core\Models\Notary\HasEmailTest
     */
    public function hasEmail(string $email): bool
    {
        return $this->emails->contains('email', $email);
    }

    /**
     * @param NationalPhone $phone
     * @return NotaryPhone
     * @throws \Throwable
     * @see \Tests\Unit\Core\Models\Notary\AddPhoneTest
     */
    public function addPhone(NationalPhone $phone): NotaryPhone
    {
        if ($this->hasPhone($phone->getValue())) {
            throw new \DomainException('Такой номер телефона уже добавлен.');
        }

        /** @var NotaryPhone $model */
        $model = $this->phones()->make();
        $model->phone = $phone->getValue();
        $model->saveOrFail();

        $this->syncCollection('phones', $model);

        return $model;
    }

    /**
     * @param Email $email
     * @return NotaryEmail
     * @throws \Throwable
     * @see \Tests\Unit\Core\Models\Notary\AddEmailTest
     */
    public function addEmail(Email $email): NotaryEmail
    {
        if ($this->hasEmail($email->getValue())) {
            throw new \DomainException('Такой e-mail уже добавлен.');
        }

        /** @var NotaryEmail $model */
        $model = $this->emails()->make();
        $model->email = $email->getValue();
        $model->saveOrFail();

        $this->syncCollection('emails', $model);

        return $model;
    }

    public function removeAllEmails(): void
    {
        $this->emails()->delete();
    }

    public function setSite(?Site $site): void
    {
        $this->site = $site?->getValue();
    }

    public function setUseDigitalReport(?bool $value): void
    {
        $this->use_digital_report = $value;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = !$comment ? null : $comment;
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(NotaryRegion::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(NotaryPhone::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(NotaryEmail::class);
    }
}
