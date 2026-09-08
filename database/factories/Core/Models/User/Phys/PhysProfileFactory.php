<?php

namespace Database\Factories\Core\Models\User\Phys;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Phys\PhysProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PhysProfile>
 */
class PhysProfileFactory extends Factory
{
    protected $model = PhysProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $secondName = $this->faker->lastName();
        $lastName = $this->faker->lastName();
        $fullName = "$firstName $secondName $lastName";

        return [
            'id' => Phys::factory(),
            'first_name' => $firstName,
            'second_name' => $secondName,
            'last_name' => $lastName,
            'full_name' => $fullName,
        ];
    }
}
