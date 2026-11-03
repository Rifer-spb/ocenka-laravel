<?php

namespace App\Manager\ReadServices\Phys;

use App\Core\Entities\Call\Call;

class PhysCallReadService
{
    public function getCall(Call $call): array
    {
        $prevCallsQuery = Call
            ::where('legal_id', $call->legal_id)
            ->where('id', '!=', $call->id);

        $prevCall = (clone $prevCallsQuery)
            ->orderByDesc('id')
            ->first();

        $prevCallsComments = (clone $prevCallsQuery)
            ->with('phys.profile')
            ->where('comment', '!=', '')
            ->where('appeared_at', '>', now()->subDays(90))
            ->orderByDesc('id')
            ->get();

        $physCallback = fn(Call $c) => [
            'name' => $c->phys->getName()
        ];

        $prevCall = $prevCall ? [
            'appearedAt' => $prevCall->appeared_at,
            'phys' => $prevCall->isCompleted() ? $physCallback($prevCall) : null,
            'isMissed' => $prevCall->isMissed()
        ] : null;

        return [
            'id' => $call->id,
            'status' => [
                'isInProcess' => $call->isInProcess(),
                'isCompleted' => $call->isCompleted(),
            ],
            'from' => [
                'phone' => $call->phone_from,
                'isMobile' => $call->isMobileFromPhone()
            ],
            'to' => ['phone' => $call->phone_to],
            'legal' => [
                'name' => $call->legal->getAbbr(),
                'fullName' => $call->legal->getFullName(),
            ],
            'phys' => $call->phys ? $physCallback($call) : null,
            'appearedAt' => $call->appeared_at,
            'prevCall' => $prevCall,
            'countPrevCalls' => $prevCallsQuery->count(),
            'prevCallsComments' => $prevCallsComments->map(fn(Call $c) => [
                'id' => $c->id,
                'appearedAt' => $c->appeared_at,
                'comment' => $c->comment,
                'phys' => $c->phys ? $physCallback($c) : null,
            ])
        ];
    }
}
