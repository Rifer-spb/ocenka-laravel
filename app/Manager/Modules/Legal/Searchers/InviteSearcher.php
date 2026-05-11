<?php

namespace App\Manager\Modules\Legal\Searchers;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Http\Requests\InviteSearchRequest;

class InviteSearcher
{
    public function search(Legal $user, InviteSearchRequest $request): array
    {
        $allRequests = Invite::where('legal_id', $user->id);

        match ($request->type) {
            'inbox' => $allRequests->where([
                'for' => Invite::FOR_LEGAL,
                'status' => InviteStatus::WAIT->value,
            ]),
            'outbox' => $allRequests->where([
                'for' => Invite::FOR_PHYS,
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
