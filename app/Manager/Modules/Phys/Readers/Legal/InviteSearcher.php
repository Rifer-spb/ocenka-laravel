<?php

namespace App\Manager\Modules\Phys\Readers\Legal;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Legal\LegalEmployee;
use App\Core\Models\Legal\LegalEmployeeStatus;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\SearchRequest;

class InviteSearcher
{
    public static function search(Phys $user, SearchRequest $request): array
    {
        $allRequests = LegalEmployee::where('phys_id', $user->id);

        match ($request->type) {
            'inbox' => $allRequests->where([
                'for' => LegalEmployee::FOR_PHYS,
                'status' => LegalEmployeeStatus::WAIT->value,
            ]),
            'outbox' => $allRequests->where([
                'for' => LegalEmployee::FOR_LEGAL,
                'status' => LegalEmployeeStatus::WAIT->value,
            ]),
            'active' => $allRequests->where([
                'status' => LegalEmployeeStatus::ACTIVE->value,
            ]),
            'fired' => $allRequests->where([
                'status' => LegalEmployeeStatus::FIRED->value,
            ]),
        };

        return array_map(function (LegalEmployee $model) {
            $status = LegalEmployeeStatus::tryFrom($model->status);

            return [
                'id' => $model->id,
                'legal' => [
                    'name' => $model->legal->getName(),
                ],
                'status' => [
                    'name' => $status->getLabel(),
                ],
                'created_at' => DateHelper::toDatetime($model->created_at),
                'rejected_at' => DateHelper::toDatetime($model->rejected_at),
                'fired_at' => DateHelper::toDatetime($model->fired_at),
            ];
        }, $allRequests->get()->all());
    }
}
