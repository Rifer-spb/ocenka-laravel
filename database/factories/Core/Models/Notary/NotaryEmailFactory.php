<?php

namespace Database\Factories\Core\Models\Notary;

use App\Core\Models\Notary\Notary;
use App\Core\Models\Notary\NotaryEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotaryEmailFactory extends Factory
{
    protected $model = NotaryEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notary_id' => Notary::factory(),
            'email' => $this->faker->email,
        ];
    }
}
