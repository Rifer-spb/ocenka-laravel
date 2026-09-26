<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Helpers\DateHelper;
use App\Core\Models\Employee\EmployeeReportAccess;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\ReadServices\InviteReadService;

class GetPageDataUseCase
{
    public function execute(Legal $legal, InviteSearchRequest $request): array
    {
        return [
            'tabs' => InviteHelper::getTabs(),
            'counts' => InviteReadService::getCounts($legal),
            'invites' => $this->search($legal, $request),
        ];
    }

    public function search(Legal $user, InviteSearchRequest $request): array
    {
        $allRequests = InviteReadService::querySearch($user, InviteTab::from($request->type))
            ->with([
                'legal.profile',
                'phys.profile',
                'phys.employee.reportAccess.direction',
            ]);

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
