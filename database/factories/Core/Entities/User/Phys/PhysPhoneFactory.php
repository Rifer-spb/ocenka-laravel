<?php

namespace Database\Factories\Core\Entities\User\Phys;

use App\Core\Entities\User\Phys\PhysPhone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PhysPhone>
 */
class PhysPhoneFactory extends Factory
{
    protected $model = PhysPhone::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function withDefault(): static
    {
        return $this->state([
            'phone' => '7' . fake()->numerify('9#########')
        ]);
    }
}
