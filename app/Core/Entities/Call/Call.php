<?php

namespace App\Core\Entities\Call;

use App\Core\Entities\AbstractEntity;
use App\Core\Entities\User\Legal\Legal;
use App\Core\ValueObjects\NationalPhone;
use Carbon\CarbonImmutable;

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
 */
class Call extends AbstractEntity
{
    private const STATUS_LOST = 0;
    private const STATUS_ANSWER_NOT_CHECK = 1;
    private const STATUS_ANSWER_CHECK = 2;
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
        $call->status = self::STATUS_LOST;
        $call->saveOrFail();

        return $call;
    }
}
