<?php

namespace Database\Factories\Core\Entities\Call;

use App\Core\Entities\Call\Call;
use App\Core\Entities\User\Legal\Legal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Call>
 */
class CallFactory extends Factory
{
    protected $model = Call::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'legal_id' => Legal::factory(),
            'mango_call_id' => Str::random(40),
            'phone_from' => '7' . fake()->numerify('9#########'),
            'phone_to' => '7' . fake()->numerify('9#########'),
            'status' => Call::STATUS_MISS,
            'appeared_at' => now()->startOfSecond()
        ];
    }
}
