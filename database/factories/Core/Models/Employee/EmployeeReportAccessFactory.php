<?php

namespace Database\Factories\Core\Models\Employee;

use App\Core\Entities\Direction;
use App\Core\Entities\Employee\EmployeeReportAccess;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeReportAccess>
 */
class EmployeeReportAccessFactory extends Factory
{
    protected $model = EmployeeReportAccess::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'direction_id' => Direction::factory(),
        ];
    }
}
