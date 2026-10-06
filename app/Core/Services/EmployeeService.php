<?php

namespace App\Core\Services;

use App\Core\Finders\EmployeeFinder;

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
        $employee = EmployeeFinder::getById($employeeId);
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
        $employee = EmployeeFinder::getById($employeeId);
        $employee->switchWriteReportAccess($accessId);
    }

    /**
     * @param int $employeeId
     * @return void
     * @throws \Throwable
     */
    public function switchRideAccess(int $employeeId): void
    {
        $employee = EmployeeFinder::getById($employeeId);
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
        $employee = EmployeeFinder::getById($employeeId);
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
        $employee = EmployeeFinder::getById($employeeId);
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
        $employee = EmployeeFinder::getById($employeeId);
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
        $employee = EmployeeFinder::getById($employeeId);
        $employee->switchCanCallAccess();
        $employee->saveOrFail();
    }
}
