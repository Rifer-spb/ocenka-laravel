<?php

namespace App\Manager\Modules\Phys\Searchers\Legal;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Http\Requests\InviteSearchRequest;

class InviteSearcher
{
    public function search(Phys $user, InviteSearchRequest $request): array
    {
        $allRequests = Invite::where('phys_id', $user->id);

        match ($request->type) {
            'inbox' => $allRequests->where([
                'for' => Invite::FOR_PHYS,
                'status' => InviteStatus::WAIT->value,
            ]),
            'outbox' => $allRequests->where([
                'for' => Invite::FOR_LEGAL,
                'status' => InviteStatus::WAIT->value,
            ]),
            'active' => $allRequests->where([
                'status' => InviteStatus::ACTIVE->value,
            ]),
            'complete' => $allRequests->where([
                'status' => InviteStatus::COMPLETE->value,
            ]),
        };

        return array_map(function (Invite $model) {
            $status = InviteStatus::tryFrom($model->status);

            return [
                'id' => $model->id,
                'legal' => [
                    'name' => $model->legal->getName(),
                ],
                'status' => [
                    'id' => $status->value,
                    'name' => $status->getLabel(),
                ],
                'created_at' => DateHelper::toDatetime($model->created_at),
                'completed_at' => DateHelper::toDatetime($model->completed_at),
            ];
        }, $allRequests->get()->all());
    }
}
