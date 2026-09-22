<?php

namespace App\Core\Models\Notary;

use App\Core\Models\AbstractEntity;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\Site;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
 */
class Notary extends AbstractEntity
{
    protected $fillable = [
        'notariat_notary_id',
        'region_id',
        'name',
        'address',
    ];
    protected $table = 'notaries';

    public static function createNew(int $notariatId, NotaryRegion $region, string $name, string $address, array $phones): self
    {
        $notary = self::create([
            'notariat_notary_id' => $notariatId,
            'region_id' => $region->id,
            'name' => $name,
            'address' => $address
        ]);

        foreach ($phones as $phone) {
            $notary->addPhone($phone);
        }

        return $notary;
    }

    public static function findByNotariatId(int $notariatId): ?self
    {
        return self::where('notariat_notary_id', $notariatId)->first();
    }

    public function hasPhone(int|string $phone): bool
    {
        return $this->phones->contains('phone', $phone);
    }

    public function hasEmail(string $email): bool
    {
        return $this->emails->contains('email', $email);
    }

    public function addPhone(int|string $phone): NotaryPhone
    {
        if ($this->hasPhone($phone)) {
            throw new \DomainException('Такой номер телефона уже добавлен.');
        }

        $model = $this->phones()->create(['phone' => $phone]);
        $this->syncCollection('phones', $model);

        return $model;
    }

    public function addEmail(Email $email): NotaryEmail
    {
        if ($this->hasEmail($email->getValue())) {
            throw new \DomainException('Такой e-mail уже добавлен.');
        }

        $model = $this->emails()->create(['email' => $email->getValue()]);
        $this->syncCollection('emails', $model);

        return $model;
    }

    public function edit(array $emails, ?Site $site, ?bool $useDigitalReport, ?string $comment): void
    {
        $this->emails()->delete();

        foreach ($emails as $email) {
            $this->addEmail($email);
        }

        $this->site = $site?->getValue();
        $this->use_digital_report = $useDigitalReport;
        $this->comment = $comment;
    }

    private function syncCollection(string $relationName, Model $model): void
    {
        if ($this->relationLoaded($relationName)) {
            $this->{$relationName}->push($model);
        }
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
