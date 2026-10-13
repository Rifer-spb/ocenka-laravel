<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Legal\Legal;
use App\Manager\Http\Controllers\Legal\EmployeeController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(EmployeeController::class,'updateManager')]
class UpdateManagerTest extends TestCase
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

        $this->assertTrue($employee->is_manager);
    }

    public function testSuccessFalse()
    {
        $employee = Employee::factory()->create(['is_manager' => true]);
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route);
        $employee->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);

        $this->assertFalse($employee->is_manager);
    }

    private function getLegal(): Legal
    {
        return Legal::factory()->create();
    }

    private function getRoute(Employee $employee): string
    {
        return route('manager.legal.employees.updateManager', [
            'employee' => $employee->id
        ]);
    }
}
