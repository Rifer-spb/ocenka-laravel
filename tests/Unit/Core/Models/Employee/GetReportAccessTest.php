<?php

namespace Tests\Unit\Core\Models\Employee;

use App\Core\Models\Employee\Employee;
use App\Core\Models\Employee\EmployeeReportAccess;
use App\Exceptions\EntityNotFoundException;
use Tests\TestCase;

class GetReportAccessTest extends TestCase
{
    public function testNotFound()
    {
        $employee = Employee::factory()->create();

        $this->expectException(EntityNotFoundException::class);

        $employee->getReportAccess(999);
    }

    public function testSuccess()
    {
        $employee = Employee::factory()
            ->withReportAccess()
            ->create();

        $accessItem = $employee->reportAccess[0];
        $result = $employee->getReportAccess($accessItem->id);

        $this->assertInstanceOf(EmployeeReportAccess::class, $result);
        $this->assertEquals($accessItem->id, $result->id);
    }
}
