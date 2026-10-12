<?php

namespace Tests\Integration\Core\Services\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Services\Call\CallCommentTemplateService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(CallCommentTemplateService::class, 'delete')]
class DeleteTest extends TestCase
{
    use TestTrait;

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $template = CallCommentTemplate::factory()->create();

        $this->service->delete($template->id);

        $this->assertDatabaseMissing(CallCommentTemplate::getTableName(), [
            'id' => $template->id
        ]);
    }
}
