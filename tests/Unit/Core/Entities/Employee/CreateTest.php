<?php

namespace Tests\Unit\Core\Entities\Employee;

use App\Core\Entities\Direction;
use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Employee\EmployeeReportAccess;
use App\Core\Entities\Invite\Invite;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Employee::class, 'createNew')]
class CreateTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $invite = Invite::factory()->withWait()->create();
        $employee = Employee::createNew($invite);

        $this->assertDatabaseHas(Employee::getTableName(), [
            'id' => $employee->id,
            'phys_id' => $invite->phys_id,
            'legal_id' => $invite->legal_id,
        ]);

        foreach (Direction::all() as $direction) {
            $this->assertDatabaseHas(EmployeeReportAccess::getTableName(), [
                'employee_id' => $employee->id,
                'direction_id' => $direction->id,
            ]);
        }
    }
}
