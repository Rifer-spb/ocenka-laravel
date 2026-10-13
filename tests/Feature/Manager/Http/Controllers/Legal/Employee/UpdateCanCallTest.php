<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Legal\Legal;
use App\Manager\Http\Controllers\Legal\EmployeeController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(EmployeeController::class,'updateCall')]
class UpdateCanCallTest extends TestCase
{
    public function testWithAnotherInviteId()
    {
        $legal = $this->getLegal();
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($legal)->patch($route);
        $response->assertStatus(404);
    }

    public function testSuccessTrue()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route);
        $employee->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);

        $this->assertTrue($employee->can_call);
    }

    public function testSuccessFalse()
    {
        $employee = Employee::factory()->create(['can_call' => true]);
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route);
        $employee->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);

        $this->assertFalse($employee->can_call);
    }

    private function getLegal(): Legal
    {
        return Legal::factory()->create();
    }

    private function getRoute(Employee $employee): string
    {
        return route('manager.legal.employees.updateCall', [
            'employee' => $employee->id
        ]);
    }
}
