<?php

namespace Database\Factories\Core\Models\User\Phys;

use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Phys\PhysProfile;
use App\Core\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Phys>
 */
class PhysFactory extends Factory
{
    protected $model = Phys::class;

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
            'password' => Hash::make('password'),
            'role' => Role::PHYS->value,
            'email_verify_token' => Str::random(60),
        ];
    }

    public function withProfile(): static
    {
        return $this->has(PhysProfile::factory(), 'profile');
    }
}
