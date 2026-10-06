<?php

namespace Database\Factories\Core\Models\Notary;

use App\Core\Entities\Notary\Notary;
use App\Core\Entities\Notary\NotaryPhone;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotaryPhoneFactory extends Factory
{
    protected $model = NotaryPhone::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notary_id' => Notary::factory(),
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
