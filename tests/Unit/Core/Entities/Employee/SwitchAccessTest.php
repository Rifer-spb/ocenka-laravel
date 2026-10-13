<?php

namespace Tests\Unit\Core\Entities\Employee;

use App\Core\Entities\Employee\Employee;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Employee::class, 'switchDoReportAccess')]
#[CoversMethod(Employee::class, 'switchWriteReportAccess')]
#[CoversMethod(Employee::class, 'switchRideAccess')]
#[CoversMethod(Employee::class, 'switchIsManagerAccess')]
#[CoversMethod(Employee::class, 'switchCanRegistryAccess')]
#[CoversMethod(Employee::class, 'switchCanCallAccess')]
class SwitchAccessTest extends TestCase
{
    /**
     * @return void
     * @throws \Throwable
     */
    public function testSwitchDoReportAccess()
    {
        $employee = Employee::factory()->withReportAccess()->create();
        $access = $employee->reportAccess[0];

        $employee->switchDoReportAccess($access->id);
        $this->assertTrue($access->do);

        $employee->switchDoReportAccess($access->id);
        $this->assertFalse($access->do);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSwitchWriteReportAccess()
    {
        $employee = Employee::factory()->withReportAccess()->create();
        $access = $employee->reportAccess[0];

        $employee->switchWriteReportAccess($access->id);
        $this->assertTrue($access->write);

        $employee->switchWriteReportAccess($access->id);
        $this->assertFalse($access->write);
    }

    public function testSwitchRideAccess()
    {
        $employee = Employee::factory()->create();

        $employee->switchRideAccess();
        $this->assertTrue($employee->can_ride);

        $employee->switchRideAccess();
        $this->assertFalse($employee->can_ride);
    }

    public function testSwitchIsManager()
    {
        $employee = Employee::factory()->create();

        $employee->switchIsManagerAccess();
        $this->assertTrue($employee->is_manager);

        $employee->switchIsManagerAccess();
        $this->assertFalse($employee->is_manager);
    }

    public function testSwitchCanRegistryAccess()
    {
        $employee = Employee::factory()->create();

        $employee->switchCanRegistryAccess();
        $this->assertTrue($employee->can_registry);

        $employee->switchCanRegistryAccess();
        $this->assertFalse($employee->can_registry);
    }

    public function testSwitchCanCallAccess()
    {
        $employee = Employee::factory()->create();

        $employee->switchCanCallAccess();
        $this->assertTrue($employee->can_call);

        $employee->switchCanCallAccess();
        $this->assertFalse($employee->can_call);
    }
}
