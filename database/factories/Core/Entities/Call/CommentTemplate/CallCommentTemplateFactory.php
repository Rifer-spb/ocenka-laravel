<?php

namespace Database\Factories\Core\Entities\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\User\Legal\Legal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CallCommentTemplate>
 */
class CallCommentTemplateFactory extends Factory
{
    protected $model = CallCommentTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'legal_id' => Legal::factory(),
            'name' => fake()->name,
            'text' => fake()->text,
        ];
    }
}
