<?php

namespace App\Core\ReadServices;

use App\Core\Entities\Employee\Employee;
use App\Core\Finders\EmployeeFinder;

class EmployeeReadService
{
    public function getAllRegistryAccess(): array
    {
        $employees = EmployeeFinder::getAll();

        $callback = fn (Employee $e) => [
            'id' => $e->id,
            'name' => $e->phys->getName(),
            'value' => $e->can_registry
        ];

        return array_map($callback, $employees);
    }

    public function getAllCallAccess(): array
    {
        $employees = EmployeeFinder::getAll();

        $callback = fn (Employee $e) => [
            'id' => $e->id,
            'name' => $e->phys->getName(),
            'value' => $e->can_call
        ];

        return array_map($callback, $employees);
    }
}
