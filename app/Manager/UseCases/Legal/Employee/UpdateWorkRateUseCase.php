<?php

namespace App\Manager\UseCases\Legal\Employee;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;

class UpdateWorkRateUseCase
{
    /**
     * @param Legal $legal
     * @param int $employeeId
     * @param int $value
     * @return void
     * @throws \Throwable
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\UpdateWorkRateUseCaseTest
     */
    public function execute(Legal $legal, int $employeeId, int $value): void
    {
        $employee = EmployeeFinder::getByIdAndLegal($employeeId, $legal);
        $employee->work_rate = $value;
        $employee->saveOrFail();
    }
}
