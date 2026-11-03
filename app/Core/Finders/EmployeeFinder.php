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

        self::validateNotFound($employee);

        return $employee;
    }

    public static function getByInvite(Invite $invite): Employee
    {
        $employee = Employee::where(['invite_id' => $invite->id])->first();

        self::validateNotFound($employee);

        return $employee;
    }

    public static function hasByLegalIdAndPhoneExtension(int $legalId, string $extension): bool
    {
        return Employee::where(['legal_id' => $legalId, 'phone_extension' => $extension])->exists();
    }

    /**
     * @param Legal $legal
     * @return array<int>
     */
    public static function findAllPhysIdWithCallAccess(Legal $legal): array
    {
        return Employee
            ::where('legal_id', $legal->id)
            ->where('can_call', true)
            ->pluck('phys_id')->all();
    }

    public static function getByPhoneExtension(string|int $extension): Employee
    {
        $employee = Employee::where(['phone_extension' => $extension])->first();

        self::validateNotFound($employee);

        return $employee;
    }

    private static function validateNotFound(?Employee $employee): void
    {
        if (! $employee) {
            throw new EntityNotFoundException('Сотрудник не найден.');
        }
    }
}
