<?php

namespace App\Manager\UseCases\Legal\Registry;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;

class UpdateAccessUseCase
{
    public function execute(Legal $legal, int $employeeId): void
    {
        $employee = EmployeeFinder::getByIdAndLegal($employeeId, $legal);
        $employee->switchCanRegistryAccess();
        $employee->saveOrFail();
    }
}
