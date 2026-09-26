<?php

namespace App\Manager\UseCases\Legal\Employee;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;

class UpdateRideUseCase
{
    /**
     * @param Legal $legal
     * @param int $employeeId
     * @return void
     * @throws \Throwable
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\UpdateRideUseCaseTest
     */
    public function execute(Legal $legal, int $employeeId): void
    {
        $employee = EmployeeFinder::getByIdAndLegal($employeeId, $legal);
        $employee->switchRideAccess();
        $employee->saveOrFail();
    }
}
