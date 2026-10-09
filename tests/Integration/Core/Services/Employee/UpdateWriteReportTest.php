<?php

namespace Tests\Integration\Core\Services\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Services\EmployeeService;
use Tests\TestCase;

class UpdateWriteReportTest extends TestCase
{
    private EmployeeService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(EmployeeService::class);
    }

    /**
     * @throws \Throwable
     */
    public function testNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Сотрудник не найден.');

        $this->service->switchWriteReportAccess(999, 777);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessTrue()
    {
        $employee = Employee::factory()->withReportAccess([
            'id' => $accessId = 1,
            'write' => false
        ])->create();

        $this->service->switchWriteReportAccess($employee->id, $accessId);

        $employee->refresh();
        $access = $employee->getReportAccess($accessId);

        $this->assertTrue($access->write);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessFalse()
    {
        $employee = Employee::factory()->withReportAccess([
            'id' => $accessId = 1,
            'write' => true
        ])->create();

        $this->service->switchWriteReportAccess($employee->id, $accessId);

        $employee->refresh();
        $access = $employee->getReportAccess($accessId);

        $this->assertFalse($access->write);
    }
}
