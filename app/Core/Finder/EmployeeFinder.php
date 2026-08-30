<?php

namespace App\Core\Finder;

use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\Invite;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeFinder
{
    public static function getByInvite(Invite $invite): Employee
    {
        $employee = Employee::where([
            'phys_id' => $invite->phys_id,
            'legal_id' => $invite->legal_id,
        ])->first();

        if (! $employee) {
            throw new ModelNotFoundException('Сотрудник не найден.');
        }

        return $employee;
    }
}
