<?php

namespace App\Core\Services;

use App\Core\Models\Employee\Employee;

class EmployeeService
{
    /**
     * @param int $employeeId
     * @param int $accessId
     * @return void
     * @throws \Throwable
     */
    public function updateDoReportAccess(int $employeeId, int $accessId): void
    {
        $employee = $this->getEmployeeId($employeeId);
        $employee->switchDoReportAccess($accessId);
    }

    /**
     * @param int $employeeId
     * @param int $accessId
     * @return void
     * @throws \Throwable
     */
    public function switchWriteReportAccess(int $employeeId, int $accessId): void
    {
        $employee = $this->getEmployeeId($employeeId);
        $employee->switchWriteReportAccess($accessId);
    }

    /**
     * @param int $employeeId
     * @return void
     * @throws \Throwable
     */
    public function switchRideAccess(int $employeeId): void
    {
        $employee = $this->getEmployeeId($employeeId);
        $employee->switchRideAccess();
        $employee->saveOrFail();
    }

    /**
     * @param int $employeeId
     * @return void
     * @throws \Throwable
     */
    public function switchIsManagerAccess(int $employeeId): void
    {
        $employee = $this->getEmployeeId($employeeId);
        $employee->switchIsManagerAccess();
        $employee->saveOrFail();
    }

    /**
     * @param int $employeeId
     * @param string $value
     * @return void
     * @throws \Throwable
     */
    public function updateWorkRate(int $employeeId, string $value): void
    {
        $employee = $this->getEmployeeId($employeeId);
        $employee->work_rate = $value;
        $employee->saveOrFail();
    }

    /**
     * @param int $employeeId
     * @return void
     * @throws \Throwable
     */
    public function switchCanRegistryAccess(int $employeeId): void
    {
        $employee = $this->getEmployeeId($employeeId);
        $employee->switchCanRegistryAccess();
        $employee->saveOrFail();
    }

    /**
     * @param int $employeeId
     * @return void
     * @throws \Throwable
     */
    public function switchCanCallAccess(int $employeeId): void
    {
        $employee = $this->getEmployeeId($employeeId);
        $employee->switchCanCallAccess();
        $employee->saveOrFail();
    }

    private function getEmployeeId(int $id): Employee
    {
        return Employee::findOrFail($id);
    }
}
