<?php

namespace Database\Factories\Core\Entities\User\Legal;

use App\Core\Entities\User\Legal\LegalPhone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LegalPhone>
 */
class LegalPhoneFactory extends Factory
{
    protected $model = LegalPhone::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return ['phone' => '7' . fake()->numerify('9#########')];
    }
}
