<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Manager\Http\Controllers\Legal\CallCommentTemplateController;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(CallCommentTemplateController::class, 'delete')]
class DeleteTest extends TestCase
{
    public function testSuccess()
    {
        $template = CallCommentTemplate::factory()->create();
        $route = $this->getRoute($template);

        $response = $this->actingAs($template->legal)->delete($route);

        $response->assertSessionHas(['success' => 'Успешно удалено']);
        $this->assertDatabaseMissing(CallCommentTemplate::getTableName(), ['id' => $template->id]);
    }

    private function getRoute(CallCommentTemplate $template): string
    {
        return route('manager.legal.callTemplates.delete', [
            'template' => $template->id,
        ]);
    }
}
