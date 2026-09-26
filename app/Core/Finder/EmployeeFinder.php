<?php

namespace App\Core\Finder;

use App\Core\Models\Employee\Employee;
use App\Core\Models\EntityNotFoundException;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;

class EmployeeFinder
{
    public static function getByInvite(Invite $invite): Employee
    {
        $employee = Employee::where(['invite_id' => $invite->id])->first();

        if (! $employee) {
            throw new EntityNotFoundException('Сотрудник не найден.');
        }

        return $employee;
    }

    public static function getRegistryAccessList(): array
    {
        return Employee::with('phys.profile')
            ->orderBy('id')
            ->get()
            ->map(fn(Employee $e) => [
                'id' => $e->id,
                'name' => $e->phys->getName(),
                'value' => $e->can_registry
            ])
            ->toArray();
    }

    public static function getByIdAndLegal(int $id, Legal $legal): Employee
    {
        $employee = Employee::where([
            'id' => $id,
            'legal_id' => $legal->id,
        ])->first();

        if (! $employee) {
            throw new EntityNotFoundException('Сотрудник не найден.');
        }

        return $employee;
    }
}
