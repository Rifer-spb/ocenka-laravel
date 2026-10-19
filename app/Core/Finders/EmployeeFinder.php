<?php

namespace App\Core\Finders;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Legal\Legal;

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

    public static function hasByLegalIdAndPhoneExtension(int $legalId, string $extension): bool
    {
        return Employee::where(['legal_id' => $legalId, 'phone_extension' => $extension])->exists();
    }

    public static function getAllPhysIdWithCallAccess(Legal $legal): array
    {
        return Employee
            ::where('legal_id', $legal->id)
            ->where('can_call', true)
            ->pluck('phys_id')->all();
    }
}
