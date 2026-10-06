<?php

namespace Database\Factories\Core\Models\Employee;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Employee\EmployeeReportAccess;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invite_id' => Invite::factory(),
            'phys_id' => Phys::factory(),
            'legal_id' => Legal::factory(),
        ];
    }

    public function withReportAccess(): static
    {
        return $this->afterCreating(function (Employee $employee) {
            EmployeeReportAccess::factory()->create([
                'employee_id' => $employee->id,
                'legal_id' => $employee->legal_id,
                'phys_id' => $employee->phys_id,
            ]);
        });
    }
}
