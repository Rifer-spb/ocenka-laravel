<?php

namespace Database\Factories\Core\Entities\User\Phys;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Phys\PhysPhone;
use App\Core\Entities\User\Phys\PhysProfile;
use App\Core\Entities\User\Role;
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

    public function withProfile(array $state = []): static
    {
        return $this->afterCreating(fn (Phys $p) => PhysProfile::factory()
            ->create(['id' => $p->id, ...$state]));
    }

    public function withPhone(array $state = []): static
    {
        return $this->afterCreating(function (Phys $p) use ($state) {
            return PhysPhone::factory()
                ->state($state)
                ->create(['user_id' => $p->id]);
        });
    }
}
