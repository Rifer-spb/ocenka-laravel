<?php

namespace Tests\Integration\Core\Services\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Services\EmployeeService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(EmployeeService::class, 'switchCanRegistryAccess')]
class UpdateCanRegistryTest extends TestCase
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

        $this->service->switchCanRegistryAccess(999);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessTrue()
    {
        $employee = Employee::factory()->create();

        $this->service->switchCanRegistryAccess($employee->id);
        $employee->refresh();

        $this->assertTrue($employee->can_registry);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessFalse()
    {
        $employee = Employee::factory()->create([
            'can_registry' => true
        ]);

        $this->service->switchCanRegistryAccess($employee->id);
        $employee->refresh();

        $this->assertFalse($employee->can_registry);
    }
}
