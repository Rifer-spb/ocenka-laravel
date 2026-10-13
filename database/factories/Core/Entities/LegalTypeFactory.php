<?php

namespace Database\Factories\Core\Entities;

use App\Core\Entities\LegalType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LegalType>
 */
class LegalTypeFactory extends Factory
{
    protected $model = LegalType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'short_name' => fake()->firstName,
        ];
    }
}
