<?php

namespace Tests\Integration\Core\Services\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Services\EmployeeService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(EmployeeService::class, 'switchRideAccess')]
class UpdateCanRideTest extends TestCase
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

        $this->service->switchRideAccess(999);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessTrue()
    {
        $employee = Employee::factory()->create();

        $this->service->switchRideAccess($employee->id);
        $employee->refresh();

        $this->assertTrue($employee->can_ride);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessFalse()
    {
        $employee = Employee::factory()->create([
            'can_ride' => true
        ]);

        $this->service->switchRideAccess($employee->id);
        $employee->refresh();

        $this->assertFalse($employee->can_ride);
    }
}
