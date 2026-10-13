<?php

namespace Database\Factories\Core\Entities\User\Legal;

use App\Core\Entities\User\Legal\LegalProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LegalProfile>
 */
class LegalProfileFactory extends Factory
{
    protected $model = LegalProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
