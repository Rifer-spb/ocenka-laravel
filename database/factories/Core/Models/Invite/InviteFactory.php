<?php

namespace Database\Factories\Core\Models\Invite;

use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invite>
 */
class InviteFactory extends Factory
{
    protected $model = Invite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phys_id' => Phys::factory(),
            'legal_id' => Legal::factory(),
            'for' => InviteForWho::PHYS->value
        ];
    }

    public function withWait(): static
    {
        return $this->state([
            'status' => InviteStatus::WAIT->value
        ]);
    }

    public function withActive(): static
    {
        return $this->state([
            'status' => InviteStatus::ACTIVE->value
        ]);
    }

    public function withForPhys(): static
    {
        return $this->state([
            'for' => InviteForWho::PHYS->value
        ]);
    }

    public function withForLegal(): static
    {
        return $this->state([
            'for' => InviteForWho::LEGAL->value
        ]);
    }
}
