<?php

namespace Database\Factories\Core\Models\User\Legal;

use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Legal>
 */
class LegalFactory extends Factory
{
    protected $model = Legal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $email = fake()->unique()->safeEmail();

        return [
            'username' => $email,
            'email' => $email,
            'password' => Str::random(8),
            'role' => Role::LEGAL->value,
            'email_verify_token' => Str::random(60),
        ];
    }
}
