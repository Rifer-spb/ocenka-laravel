<?php

namespace App\Manager\ReadServices\Legal;

use App\Core\Entities\Employee\EmployeeReportAccess;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Helpers\DateHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Queries\Legal\LegalInviteQuery;

class LegalInviteSearchService
{
    public function search(Legal $legal, InviteSearchRequest $request): array
    {
        $invites = LegalInviteQuery::searchQuery($legal, InviteTab::from($request->type));

        return array_map(function (Invite $model) {
            return [
                'id' => $model->id,
                'phys' => $this->getPhys($model),
                'status' => $this->getStatus($model),
                'employee' => $this->getEmployee($model),
                'created_at' => DateHelper::toDatetime($model->created_at),
                'completed_at' => DateHelper::toDatetime($model->completed_at),
            ];
        }, $invites->get()->all());
    }

    private function getPhys(Invite $model): array
    {
        return [
            'name' => $model->phys->getName(),
        ];
    }

    private function getStatus(Invite $model): array
    {
        $status = InviteStatus::tryFrom($model->status);

        return [
            'id' => $status->value,
            'name' => $status->getLabel(),
        ];
    }

    private function getEmployee(Invite $model): array
    {
        if (! $model->isActive()) {
            return [];
        }

        $phys = $model->phys;
        $employee = $phys->employee;
        $reportAccesses = $employee->reportAccess;

        return [
            'id' => $employee->id,
            'name' => $phys->getName(),
            'access' => [
                'ride' => $employee->can_ride,
                'report' => $reportAccesses->map(fn (EmployeeReportAccess $a) => [
                    'id' => $a->id,
                    'name' => $a->direction->short_name,
                    'do' => $a->do,
                    'write' => $a->write,
                ]),
            ],
            'isManager' => $employee->is_manager,
            'workRate' => $employee->work_rate,
        ];
    }
}
