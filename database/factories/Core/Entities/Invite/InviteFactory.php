<?php

namespace Database\Factories\Core\Entities\Invite;

use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
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

    public function withComplete(): static
    {
        return $this->state([
            'status' => InviteStatus::COMPLETE->value
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

    public function withEmployee(): static
    {
        return $this->afterCreating(function (Invite $i) {
            return Employee::factory()
                ->state([
                    'invite_id' => $i->id,
                    'phys_id' => $i->phys_id,
                    'legal_id' => $i->legal_id,
                ])
                ->withReportAccess()
                ->create();
        });
    }
}
