<?php

namespace App\Core\Finder;

use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\Invite;

class EmployeeFinder
{
    public static function getByInvite(Invite $invite): Employee
    {
        $employee = Employee::where([
            'phys_id' => $invite->phys_id,
            'legal_id' => $invite->legal_id,
        ])->first();

        if (! $employee) {
            throw new \RuntimeException('Сотрудник не найден.');
        }

        return $employee;
    }
}
