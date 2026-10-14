<?php

namespace App\Core\ReadServices;

use App\Core\Entities\Employee\Employee;
use App\Core\Finders\EmployeeFinder;

class EmployeeReadService
{
    public function getAllRegistryAccess(int $legalId): array
    {
        $employees = EmployeeFinder::getAllByLegalId($legalId);

        $callback = fn (Employee $e) => [
            'id' => $e->id,
            'name' => $e->phys->getName(),
            'value' => $e->can_registry
        ];

        return array_map($callback, $employees);
    }

    public function getAllCallAccess(int $legalId): array
    {
        $employees = EmployeeFinder::getAllByLegalId($legalId);

        $callback = fn (Employee $e) => [
            'id' => $e->id,
            'name' => $e->phys->getName(),
            'value' => $e->can_call
        ];

        return array_map($callback, $employees);
    }
}
