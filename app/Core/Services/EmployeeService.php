<?php

namespace App\Core\Services;

use App\Core\Models\Employee\Employee;

class EmployeeService
{
    public function switchDoReportAccess(Employee $employee, int $accessId): void
    {
        $employee->switchDoReportAccess($accessId);
    }

    public function switchWriteReportAccess(Employee $employee, int $accessId): void
    {
        $employee->switchWriteReportAccess($accessId);
    }

    public function switchRideAccess(Employee $employee): void
    {
        $employee->switchRideAccess();
    }

    public function switchIsManagerAccess(Employee $employee): void
    {
        $employee->switchIsManagerAccess();
    }

    public function updateWorkRate(Employee $employee, string $value): void
    {
        $employee->work_rate = $value;
        $employee->saveOrFail();
    }

    public function switchCanRegistryAccess(Employee $employee): void
    {
        $employee->switchCanRegistryAccess();
    }

    public function switchCanCallAccess(Employee $employee): void
    {
        $employee->switchCanCallAccess();
    }
}
