<?php

namespace Database\Factories\Core\Models\Notary;

use App\Core\Models\Notary\Notary;
use App\Core\Models\Notary\NotaryPhone;
use App\Core\Models\Notary\NotaryRegion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notary>
 */
class NotaryFactory extends Factory
{
    protected $model = Notary::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notariat_notary_id' => $this->faker->numberBetween(1, 100),
            'region_id' => NotaryRegion::query()->inRandomOrder()->value('id'),
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'site' => $this->faker->url(),
            'comment' => $this->faker->text(),
        ];
    }

    public function withPhone(int $phone): static
    {
        return $this->afterCreating(function (Notary $n) use ($phone) {
            return NotaryPhone::factory()
                ->state([
                    'notary_id' => $n->id,
                    'phone' => $phone,
                ])
                ->create();
        });
    }
}
