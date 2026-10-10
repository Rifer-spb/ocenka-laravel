<?php

namespace Tests\Integration\Core\Services\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Services\EmployeeService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(EmployeeService::class, 'switchDoReportAccess')]
class UpdateDoReportTest extends TestCase
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

        $this->service->switchDoReportAccess(999, 777);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessTrue()
    {
        $employee = Employee::factory()->withReportAccess([
            'id' => $accessId = 1,
            'do' => false
        ])->create();

        $this->service->switchDoReportAccess($employee->id, $accessId);

        $employee->refresh();
        $access = $employee->getReportAccess($accessId);

        $this->assertTrue($access->do);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessFalse()
    {
        $employee = Employee::factory()->withReportAccess([
            'id' => $accessId = 1,
            'do' => true
        ])->create();

        $this->service->switchDoReportAccess($employee->id, $accessId);

        $employee->refresh();
        $access = $employee->getReportAccess($accessId);

        $this->assertFalse($access->do);
    }
}
