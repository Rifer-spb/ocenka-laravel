<?php

namespace Database\Factories\Core\Entities\Employee;

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

    public function withReportAccess(array $state = []): static
    {
        $callback = function (Employee $employee) use ($state) {
            $data = [
                'employee_id' => $employee->id,
                'legal_id' => $employee->legal_id,
                'phys_id' => $employee->phys_id,
                ...$state
            ];

            EmployeeReportAccess::factory()->create($data);
        };

        return $this->afterCreating($callback);
    }
}
