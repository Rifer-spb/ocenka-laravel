<?php

namespace App\Core\Entities\Call;

use App\Core\Entities\AbstractEntity;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\ValueObjects\NationalPhone;
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
 * @property string $appeared_at
 * @property null|string $connected_at
 * @property null|string $ended_at
 * @property null|string $talk_time
 * @property null|BelongsTo|Phys $phys
 * @property null|BelongsTo|Legal $legal
 */
class Call extends AbstractEntity
{
    private const STATUS_INCOMING = 0;
    private const STATUS_NOT_CHECK_COMPLETED = 1;
    private const STATUS_CHECKED_COMPLETED = 2;
    private const STATUS_IN_PROCESS = 3;

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
        $call->status = self::STATUS_INCOMING;
        $call->saveOrFail();

        return $call;
    }

    public function isMobile(): bool
    {
        return $this->phone_from[1] == 9;
    }

    public function isCompleted(): bool
    {
        return
            $this->status == self::STATUS_NOT_CHECK_COMPLETED
            || $this->status == self::STATUS_CHECKED_COMPLETED;
    }

    public function isInProgress(): bool
    {
        return $this->status == self::STATUS_IN_PROCESS;
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
