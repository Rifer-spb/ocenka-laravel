<?php

namespace Tests\Integration\Core\Services\Call;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Services\Call\CallCommentTemplateService;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversMethod(CallCommentTemplateService::class, 'delete')]
class DeleteTest extends AbstractTest
{
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
