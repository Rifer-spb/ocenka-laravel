<?php

namespace App\Core\Services;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Employee\PhoneExtension;
use App\Core\Finders\EmployeeFinder;
use Tests\Integration\Core\Services\Employee\UpdateDoReportTest;
use Tests\Integration\Core\Services\Employee\UpdatePhoneExtensionTest;
use Tests\Integration\Core\Services\Employee\UpdateWriteReportTest;
use Tests\Integration\Core\Services\Employee\UpdateCanRideTest;
use Tests\Integration\Core\Services\Employee\UpdateIsManagerTest;
use Tests\Integration\Core\Services\Employee\UpdateWorkRateTest;
use Tests\Integration\Core\Services\Employee\UpdateCanCallTest;
use Tests\Integration\Core\Services\Employee\UpdateCanRegistryTest;

class EmployeeService
{
    /**
     * @param int $employeeId
     * @param int $accessId
     * @return void
     * @throws \Throwable
     */
    #[TestClass(UpdateDoReportTest::class)]
    public function switchDoReportAccess(int $employeeId, int $accessId): void
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
    #[TestClass(UpdateWriteReportTest::class)]
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
    #[TestClass(UpdateCanRideTest::class)]
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
    #[TestClass(UpdateIsManagerTest::class)]
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
    #[TestClass(UpdateWorkRateTest::class)]
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
    #[TestClass(UpdateCanRegistryTest::class)]
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
    #[TestClass(UpdateCanCallTest::class)]
    public function switchCanCallAccess(int $employeeId): void
    {
        $employee = EmployeeFinder::getById($employeeId);
        $employee->switchCanCallAccess();
        $employee->saveOrFail();
    }

    /**
     * @param int $employeeId
     * @param PhoneExtension $extension
     * @return void
     * @throws \Throwable
     */
    #[TestClass(UpdatePhoneExtensionTest::class)]
    public function updatePhoneExtension(int $employeeId, PhoneExtension $extension): void
    {
        $employee = EmployeeFinder::getById($employeeId);

        if ($extension->hasValue()) {
            $legalId = $employee->legal_id;
            $extensionValue = $extension->getValue();
            $hasAnotherExtension = EmployeeFinder::hasByLegalIdAndPhoneExtension($legalId, $extensionValue);

            if ($hasAnotherExtension) {
                throw new \DomainException('Такой внутренний номер уже добавлен.');
            }
        }

        $employee->updatePhoneExtension($extension);
        $employee->saveOrFail();
    }
}
