<?php

namespace App\Core\Finders;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;

class EmployeeFinder
{
    public static function getById(int $id): Employee
    {
        $employee = Employee::find($id);

        if (! $employee) {
            throw new EntityNotFoundException('Сотрудник не найден.');
        }

        return $employee;
    }

    public static function getByInvite(Invite $invite): Employee
    {
        $employee = Employee::where(['invite_id' => $invite->id])->first();

        if (! $employee) {
            throw new EntityNotFoundException('Сотрудник не найден.');
        }

        return $employee;
    }

    /**
     * @return Employee[]
     */
    public static function getAllByLegalId(int $legalId): array
    {
        return Employee::with(['phys.profile', 'reportAccess'])
            ->where('legal_id', $legalId)
            ->orderBy('id')
            ->get()
            ->all();
    }
}
