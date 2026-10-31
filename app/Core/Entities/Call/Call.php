<?php

namespace App\Core\Entities\Call;

use App\Core\Entities\AbstractEntity;
use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\ValueObjects\NationalPhone;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
 */
class Call extends AbstractEntity
{
    private const STATUS_LOST = 0;
    private const STATUS_NOT_CHECK_COMPLETED = 1;
    private const STATUS_CHECKED_COMPLETED = 2;
    private const STATUS_IN_PROCESS = 3;

    protected $casts = [
        'appeared_at' => 'datetime',
        'connected_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * @throws \Throwable
     */
    public static function createNew(Legal $legal, MangoCallId $mangoCallId, NationalPhone $phoneFrom, NationalPhone $phoneTo, CarbonImmutable $appearedAt): self
    {
        $call = new self();
        $call->legal_id = $legal->id;
        $call->mango_call_id = $mangoCallId->getValue();
        $call->phone_from = $phoneFrom->getValue();
        $call->phone_to = $phoneTo->getValue();
        $call->appeared_at = $appearedAt->format('Y-m-d H:i:s');
        $call->status = self::STATUS_LOST;
        $call->saveOrFail();

        return $call;
    }

    public function isMobile(): bool
    {
        return $this->phone_from[1] == 9;
    }

    public function isMissed(): bool
    {
        return $this->status == self::STATUS_LOST;
    }

    public function isCompleted(): bool
    {
        return
            $this->status == self::STATUS_NOT_CHECK_COMPLETED
            || $this->status == self::STATUS_CHECKED_COMPLETED;
    }

    public function isInProcess(): bool
    {
        return $this->status == self::STATUS_IN_PROCESS;
    }

    public function connectedBy(Employee $employee, CarbonImmutable $connectedAt): void
    {
        if (! $this->isMissed()) {
            throw new \DomainException('Звонок должен быть в статусе входящего.');
        }

        $this->phys_id = $employee->phys_id;
        $this->connected_at = $connectedAt->format('Y-m-d H:i:s');
        $this->status = self::STATUS_IN_PROCESS;
    }

    public function ended(CarbonImmutable $endedAt): void
    {
        if (! $this->isInProcess()) {
            throw new \DomainException('Звонок не был поднят.');
        }

        $this->ended_at = $endedAt->format('Y-m-d H:i:s');

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
