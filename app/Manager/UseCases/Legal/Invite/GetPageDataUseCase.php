<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Employee\EmployeeReportAccess;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;

class GetPageDataUseCase
{
    public function execute(Legal $legal, InviteSearchRequest $request): array
    {
        return [
            'staticTabs' => InviteHelper::getTabs(),
            'counts' => InviteFinder::getCounts($legal),
            'invites' => $this->search($legal, $request),
        ];
    }

    public function search(Legal $user, InviteSearchRequest $request): array
    {
        $allRequests = Invite::where('legal_id', $user->id)->with([
            'legal.profile',
            'phys.profile',
            'phys.employee.reportAccess.direction',
        ]);

        match ($request->type) {
            'inbox' => $allRequests->where([
                'for' => InviteForWho::LEGAL->value,
                'status' => InviteStatus::WAIT->value,
            ]),
            'outbox' => $allRequests->where([
                'for' => InviteForWho::PHYS->value,
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
                'employee' => $this->getEmployee($model),
            ];
        }, $allRequests->get()->all());
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
            'name' => $phys->getFullName(),
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
