<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Manager\Http\Controllers\Legal\CallCommentTemplateController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(CallCommentTemplateController::class, 'update')]
class UpdateTest extends TestCase
{
    public function testRequired()
    {
        $template = CallCommentTemplate::factory()->create();
        $route = $this->getRoute($template);

        $response = $this->actingAs($template->legal)->patch($route, [
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
        $template = CallCommentTemplate::factory()->create();
        $route = $this->getRoute($template);

        $response = $this->actingAs($template->legal)->patch($route, [
            'name' => str_repeat('a', 256),
            'text' => 'text',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'Максимальная длинна 255 символов',
        ]);
    }

    public function testSuccess()
    {
        $template = CallCommentTemplate::factory()->create();
        $route = $this->getRoute($template);

        $response = $this->actingAs($template->legal)->patch($route, [
            'name' => $name = 'new-name',
            'text' => $text = 'new-text',
        ]);

        $response->assertSessionHas(['success' => 'Успешно обновлено']);
        $template->refresh();

        $this->assertEquals($name, $template->name);
        $this->assertEquals($text, $template->text);
    }

    private function getRoute(CallCommentTemplate $template): string
    {
        return route('manager.legal.callTemplates.update', [
            'template' => $template->id,
        ]);
    }
}
