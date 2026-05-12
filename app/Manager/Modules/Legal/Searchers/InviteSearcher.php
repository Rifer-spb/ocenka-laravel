<?php

namespace App\Manager\Modules\Legal\Searchers;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Employee\EmployeeReportAccess;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Http\Requests\InviteSearchRequest;

class InviteSearcher
{
    public function search(Legal $user, InviteSearchRequest $request): array
    {
        $allRequests = Invite::where('legal_id', $user->id)->with([
            'legal.profile',
            'phys.profile',
            'phys.reportAccesses',
            'phys.reportAccesses.direction',
            'phys.rideAccess',
        ]);

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
                'user' => $this->getPhys($model),
            ];
        }, $allRequests->get()->all());
    }

    private function getPhys(Invite $model): array
    {
        if (! $model->isActive()) {
            return [];
        }

        $phys = $model->phys;
        $rideAccess = $phys->rideAccess;
        $reportAccesses = $phys->reportAccesses;

        return [
            'name' => $phys->getFullName(),
            'access' => [
                'ride' => [
                    'id' => $rideAccess->id,
                    'value' => $rideAccess->value,
                ],
                'report' => $reportAccesses->map(function (EmployeeReportAccess $a) {
                    return [
                        'id' => $a->id,
                        'name' => $a->direction->short_name,
                        'do' => $a->do,
                        'write' => $a->write,
                    ];
                }),
            ],
        ];
    }
}
