<?php

namespace App\Core\Entities\Call;

use App\Core\Attributes\TestClass;
use App\Core\Entities\AbstractEntity;
use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\ValueObjects\NationalPhone;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Database\Factories\Core\Entities\Call\CallFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\Unit\Core\Entities\Call\ConnectedByTest;
use Tests\Unit\Core\Entities\Call\CreateTest;
use Tests\Unit\Core\Entities\Call\EndedTest;
use Tests\Unit\Core\Entities\Call\StatusTest;
use Tests\Unit\Core\Entities\Call\IsMobileFromPhoneTest;

/**
 * @property int $id
 * @property int $legal_id
 * @property int $phys_id
 * @property string $mango_call_id
 * @property string $phone_from
 * @property string $phone_to
 * @property int $status
 * @property string $comment
 * @property string|Carbon $appeared_at
 * @property null|string|Carbon $connected_at
 * @property null|string|Carbon $ended_at
 * @property null|string $talk_time
 * @property null|BelongsTo|Phys $phys
 * @property null|BelongsTo|Legal $legal
 *
 * @method static CallFactory factory()
 */
class Call extends AbstractEntity
{
    /**
     * По умолчанию у входящего звонка ставится статус пропущен (STATUS_MISS).
     * По идее можно было бы добавить статус входящего звонка (STATUS_INCOME) и его указывать,
     * а уже потом устанавливать статус на пропущен (STATUS_MISS), если он был действительно пропущен.
     * Но дело в том, что если mango office по каким либо причинам не кинет запрос о входящем звонке,
     * о том, что он был пропущен, то звонок в системе будет так и висеть как входящий.
     * Плюс сам mango не особо различает входящие и пропущенные звонки.
     * Поэтому было принято решение о том, чтобы у звонка сразу проставлять статус как пропущен.
     * А там уже, если кто ответит на этот звонок то он уже перейдет в статус разговора.
     */
    const STATUS_MISS = 0;
    const STATUS_NOT_CHECK_COMPLETED = 1;
    const STATUS_CHECKED_COMPLETED = 2;
    const STATUS_IN_PROCESS = 3;

    protected $casts = [
        'appeared_at' => 'datetime',
        'connected_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * @throws \Throwable
     */
    #[TestClass(CreateTest::class)]
    public static function createNew(Legal $legal, MangoCallId $mangoCallId, NationalPhone $phoneFrom, NationalPhone $phoneTo, CarbonImmutable $appearedAt): self
    {
        $call = new self();
        $call->legal_id = $legal->id;
        $call->mango_call_id = $mangoCallId->getValue();
        $call->phone_from = $phoneFrom->getValue();
        $call->phone_to = $phoneTo->getValue();
        $call->appeared_at = $appearedAt;
        $call->status = self::STATUS_MISS;
        $call->saveOrFail();

        return $call;
    }

    #[TestClass(IsMobileFromPhoneTest::class)]
    public function isMobileFromPhone(): bool
    {
        return $this->phone_from[1] == 9;
    }

    #[TestClass(StatusTest::class)]
    public function isMissed(): bool
    {
        return $this->status == self::STATUS_MISS;
    }

    #[TestClass(StatusTest::class)]
    public function isCompleted(): bool
    {
        return
            $this->status == self::STATUS_NOT_CHECK_COMPLETED
            || $this->status == self::STATUS_CHECKED_COMPLETED;
    }

    #[TestClass(StatusTest::class)]
    public function isInProcess(): bool
    {
        return $this->status == self::STATUS_IN_PROCESS;
    }

    #[TestClass(ConnectedByTest::class)]
    public function connectedBy(Employee $employee, CarbonImmutable $connectedAt): void
    {
        if (! $this->isMissed()) {
            throw new \DomainException('Звонок должен быть в статусе входящего.');
        }

        if ($connectedAt < $this->appeared_at) {
            throw new \DomainException('Дата начала разговора не может быть раньше даты звонка.');
        }

        $this->phys_id = $employee->phys_id;
        $this->connected_at = $connectedAt;
        $this->status = self::STATUS_IN_PROCESS;
    }

    #[TestClass(EndedTest::class)]
    public function ended(CarbonImmutable $endedAt): void
    {
        if (! $this->isInProcess()) {
            throw new \DomainException('Звонок не был поднят.');
        }

        if ($endedAt < $this->connected_at) {
            throw new \DomainException('Дата завершения звонка не может быть раньше даты начала звонка.');
        }

        $this->ended_at = $endedAt;

        $seconds = $this->ended_at->timestamp - $this->connected_at->timestamp;
        $this->talk_time = gmdate('i:s', $seconds % 86400);

        if (empty($this->comment)) {
            $this->status = self::STATUS_NOT_CHECK_COMPLETED;
        } else {
            $this->status = self::STATUS_CHECKED_COMPLETED;
        }
    }

    public function legal(): BelongsTo
    {
        return $this->belongsTo(Legal::class);
    }

    public function phys(): BelongsTo
    {
        return $this->belongsTo(Phys::class);
    }
}
