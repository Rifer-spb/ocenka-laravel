<?php

namespace Tests\Unit\Core\Entities\Employee;

use App\Core\Entities\Employee\Employee;
use Tests\TestCase;

class SwitchAccessTest extends TestCase
{
    public function testSwitchDoReportAccess()
    {
        $employee = Employee::factory()->withReportAccess()->create();
        $access = $employee->reportAccess[0];

        $employee->switchDoReportAccess($access->id);
        $this->assertTrue($access->do);

        $employee->switchDoReportAccess($access->id);
        $this->assertFalse($access->do);
    }

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
}
