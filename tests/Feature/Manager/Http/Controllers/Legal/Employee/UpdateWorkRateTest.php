<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\User\Legal\Legal;
use Tests\TestCase;

class UpdateWorkRateTest extends TestCase
{
    public function testWithAnotherInviteId()
    {
        $legal = $this->getLegal();
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($legal)->patch($route);
        $response->assertStatus(404);
    }

    public function testRequired()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => ''
        ]);
        $employee->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
        $this->assertEquals(0, $employee->work_rate);
    }

    public function testInteger()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => 'value'
        ]);

        $response->assertSessionHasErrors(['value' => 'Значение должно быть числом']);
    }

    public function testMin()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => -5
        ]);

        $response->assertSessionHasErrors(['value' => 'Значение не может быть отрицательным']);
    }

    public function testSuccess()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => $value = 9
        ]);
        $employee->refresh();

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
        $this->assertEquals($value, $employee->work_rate);
    }

    private function getLegal(): Legal
    {
        return Legal::factory()->create();
    }

    private function getRoute(Employee $employee): string
    {
        return route('manager.legal.employees.updateWorkRate', [
            'employee' => $employee->id
        ]);
    }
}
