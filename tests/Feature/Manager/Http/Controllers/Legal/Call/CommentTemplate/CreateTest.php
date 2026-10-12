<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\User\Legal\Legal;
use App\Manager\Http\Controllers\Legal\CallCommentTemplateController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(CallCommentTemplateController::class, 'create')]
class CreateTest extends TestCase
{
    public function testRequired()
    {
        $route = $this->getRoute();
        $legal = Legal::factory()->create();

        $response = $this->actingAs($legal)->post($route, [
            'name' => '',
            'text' => '',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'Необходимо заполнить имя',
            'text' => 'Необходимо заполнить текст шаблона'
        ]);
    }

    public function testMaxName()
    {
        $route = $this->getRoute();
        $legal = Legal::factory()->create();

        $response = $this->actingAs($legal)->post($route, [
            'name' => str_repeat('a', 256),
            'text' => 'text',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'Максимальная длинна 255 символов',
        ]);
    }

    public function testSuccess()
    {
        $route = $this->getRoute();
        $legal = Legal::factory()->create();

        $response = $this->actingAs($legal)->post($route, [
            'name' => $name = 'new-name',
            'text' => $text = 'new-text',
        ]);

        $response->assertSessionHas(['success' => 'Успешно добавлено']);
        $this->assertDatabaseHas(CallCommentTemplate::getTableName(), [
            'legal_id' => $legal->id,
            'name' => $name,
            'text' => $text,
        ]);
        $this->assertDatabaseCount(CallCommentTemplate::getTableName(), 1);
    }

    private function getRoute(): string
    {
        return route('manager.legal.callTemplates.create');
    }
}
