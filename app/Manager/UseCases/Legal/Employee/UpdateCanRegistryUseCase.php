<?php

namespace App\Manager\UseCases\Legal\Employee;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;

class UpdateCanRegistryUseCase
{
    public function execute(Legal $legal, int $employeeId): void
    {
        $employee = EmployeeFinder::getByIdAndLegal($employeeId, $legal);
        $employee->switchCanRegistryAccess();
        $employee->saveOrFail();
    }
}
