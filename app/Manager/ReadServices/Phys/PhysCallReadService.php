<?php

namespace App\Manager\ReadServices\Phys;

use App\Core\Entities\Call\Call;

class PhysCallReadService
{
    public function getCall(Call $call): array
    {
        $prevCallsQuery = Call
            ::where('legal_id', $call->legal_id)
            ->whereNot('id', $call->id);

        $prevCall = $prevCallsQuery
            ->orderByDesc('id')
            ->first();

        $prevCall = $prevCall ? [
            'appearedAt' => $prevCall->appeared_at,
            'phys' => $prevCall->isCompleted() ? [
                'name' => $call->phys->getName()
            ] : null
        ] : null;

        return [
            'id' => $call->id,
            'status' => [
                'isInProcess' => $call->isInProgress(),
                'isCompleted' => $call->isCompleted(),
            ],
            'from' => [
                'phone' => $call->phone_from,
                'isMobile' => $call->isMobile()
            ],
            'to' => ['phone' => $call->phone_to],
            'legal' => [
                'name' => $call->legal->getAbbr(),
                'fullName' => $call->legal->getFullName(),
            ],
            'phys' => $call->phys ? [
                'name' => $call->phys->getName()
            ] : null,
            'appearedAt' => $call->appeared_at,
            'prevCall' => $prevCall,
            'countPrevCalls' => $prevCallsQuery->count(),
        ];
    }
}
