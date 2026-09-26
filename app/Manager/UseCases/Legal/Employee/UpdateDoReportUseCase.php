<?php

namespace App\Manager\UseCases\Legal\Employee;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;

class UpdateDoReportUseCase
{
    /**
     * @param Legal $legal
     * @param int $employeeId
     * @param int $accessId
     * @return void
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\UpdateDoReportUseCaseTest
     */
    public function execute(Legal $legal, int $employeeId, int $accessId): void
    {
        $employee = EmployeeFinder::getByIdAndLegal($employeeId, $legal);
        $employee->switchDoReportAccess($accessId);
    }
}
