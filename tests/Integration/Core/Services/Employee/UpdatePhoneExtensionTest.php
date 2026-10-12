<?php

namespace Tests\Integration\Core\Services\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Employee\PhoneExtension;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Services\EmployeeService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(EmployeeService::class, 'updatePhoneExtension')]
class UpdatePhoneExtensionTest extends TestCase
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
     * @throws \Throwable
     */
    public function testSuccessWithValue()
    {
        $employee = Employee::factory()->create();

        $this->service->updatePhoneExtension($employee->id, new PhoneExtension($value = 101));
        $employee->refresh();

        $this->assertEquals($value, $employee->phone_extension);
    }

    /**
     * @throws \Throwable
     */
    public function testSuccessWithNull()
    {
        $employee = Employee::factory()->create();

        $this->service->updatePhoneExtension($employee->id, new PhoneExtension(null));
        $employee->refresh();

        $this->assertNull($employee->phone_extension);
    }
}
