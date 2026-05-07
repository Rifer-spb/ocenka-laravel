<?php

namespace App\Manager\Modules\Phys\Searchers\Legal;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Legal\LegalEmployee;
use App\Core\Models\Legal\LegalInviteStatus;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Http\Requests\InviteSearchRequest;

class InviteSearcher
{
    public static function search(Phys $user, InviteSearchRequest $request): array
    {
        $allRequests = LegalEmployee::where('phys_id', $user->id);

        match ($request->type) {
            'inbox' => $allRequests->where([
                'for' => LegalEmployee::FOR_PHYS,
                'status' => LegalInviteStatus::WAIT->value,
            ]),
            'outbox' => $allRequests->where([
                'for' => LegalEmployee::FOR_LEGAL,
                'status' => LegalInviteStatus::WAIT->value,
            ]),
            'active' => $allRequests->where([
                'status' => LegalInviteStatus::ACTIVE->value,
            ]),
            'complete' => $allRequests->where([
                'status' => LegalInviteStatus::COMPLETE->value,
            ]),
        };

        return array_map(function (LegalEmployee $model) {
            $status = LegalInviteStatus::tryFrom($model->status);

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
                'rejected_at' => DateHelper::toDatetime($model->rejected_at),
                'fired_at' => DateHelper::toDatetime($model->fired_at),
            ];
        }, $allRequests->get()->all());
    }
}
