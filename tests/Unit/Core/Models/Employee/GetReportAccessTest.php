<?php

namespace Tests\Unit\Core\Models\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Employee\EmployeeReportAccess;
use App\Core\Entities\EntityNotFoundException;
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
