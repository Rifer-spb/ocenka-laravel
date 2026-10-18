<?php

namespace App\Manager\PageData\Legal\Settings\Invite;

use App\Core\Entities\Employee\EmployeeReportAccess;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Helpers\DateHelper;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;

class InviteSearcher
{
    public function search(Legal $legal, InviteSearchRequest $request): array
    {
        $tab = InviteTab::from($request->type);
        $tabStatus = InviteHelper::getStatusByTab($tab);

        $query = Invite::where('legal_id', $legal->id)
            ->with([
                'phys.profile',
                'phys.employee.reportAccess.direction',
            ])
            ->where('status', $tabStatus->value);

        if ($tab->isInbox()) {
            $query->where('for', InviteForWho::LEGAL);
        } elseif ($tab->isOutbox()) {
            $query->where('for', InviteForWho::PHYS);
        };

        return $query->get()->map($this->getInvite(...))->all();
    }

    private function getInvite(Invite $model): array
    {
        return [
            'id' => $model->id,
            'phys' => $this->getPhys($model),
            'status' => $this->getStatus($model),
            'employee' => $this->getEmployee($model),
            'created_at' => DateHelper::toDatetime($model->created_at),
            'completed_at' => DateHelper::toDatetime($model->completed_at),
        ];
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
