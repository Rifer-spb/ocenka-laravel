<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Employee;

use App\Core\Entities\Employee\Employee;
use App\Manager\Http\Controllers\Legal\EmployeeController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(EmployeeController::class, 'updatePhoneExtension')]
class UpdatePhoneExtensionTest extends TestCase
{
    public function testWithZero()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => '0'
        ]);

        $response->assertSessionHasErrors([
            'value' => 'Значение должно быть от 1 до 3 цифр'
        ]);
    }

    public function testMaxNumber()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => '1000'
        ]);

        $response->assertSessionHasErrors([
            'value' => 'Значение должно быть от 1 до 3 цифр'
        ]);
    }

    public function testStringWithFirstNumber()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => 'abc12345'
        ]);

        $response->assertSessionHasErrors([
            'value' => 'Значение должно быть от 1 до 3 цифр',
        ]);
    }

    public function testStringWithLastNumber()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => '12345abc'
        ]);

        $response->assertSessionHasErrors([
            'value' => 'Значение должно быть от 1 до 3 цифр',
        ]);
    }

    public function testExist()
    {
        $employee = Employee::factory()->create(['phone_extension' => 101]);
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => '101'
        ]);

        $response->assertSessionHasErrors([
            'value' => 'Номер уже занят',
        ]);
    }

    public function testSuccessWithNumber()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => $value = '999'
        ]);

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
        $employee->refresh();

        $this->assertEquals($value, $employee->phone_extension);
    }

    public function testSuccessWithEmpty()
    {
        $employee = Employee::factory()->create();
        $route = $this->getRoute($employee);

        $response = $this->actingAs($employee->legal)->patch($route, [
            'value' => ''
        ]);

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
        $employee->refresh();

        $this->assertNull($employee->phone_extension);
    }

    private function getRoute(Employee $employee): string
    {
        return route('manager.legal.employees.updatePhoneExtension', [
            'employee' => $employee->id
        ]);
    }
}
