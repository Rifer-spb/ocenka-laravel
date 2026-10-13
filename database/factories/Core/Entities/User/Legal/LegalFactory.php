<?php

namespace Database\Factories\Core\Entities\User\Legal;

use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Legal\LegalPhone;
use App\Core\Entities\User\Legal\LegalProfile;
use App\Core\Entities\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
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
            'password' => Hash::make('password'),
            'role' => Role::LEGAL->value,
            'email_verify_token' => Str::random(60),
        ];
    }

    public function withProfile(array $state = []): static
    {
        return $this->afterCreating(
            fn (Legal $l) => LegalProfile::factory()->create(['id' => $l->id, ...$state])
        );
    }

    public function withPhone(array $state = []): static
    {
        return $this->afterCreating(function (Legal $l) use ($state) {
            return LegalPhone::factory()
                ->state($state)
                ->create(['legal_id' => $l->id]);
        });
    }
}
