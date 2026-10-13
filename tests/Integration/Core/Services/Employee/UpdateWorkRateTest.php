<?php

namespace Tests\Integration\Core\Services\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Services\EmployeeService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(EmployeeService::class, 'updateWorkRate')]
class UpdateWorkRateTest extends TestCase
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

        $this->service->updateWorkRate(999, 999);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $employee = Employee::factory()->create();

        $this->service->updateWorkRate($employee->id, $value = 10);
        $employee->refresh();

        $this->assertEquals($value, $employee->work_rate);
    }
}
