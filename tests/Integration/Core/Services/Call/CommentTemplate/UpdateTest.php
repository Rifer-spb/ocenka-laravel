<?php

namespace Tests\Integration\Core\Services\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\Call\CommentTemplate\Name;
use App\Core\Entities\Call\CommentTemplate\Text;
use App\Core\Services\Call\CallCommentTemplateService;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(CallCommentTemplateService::class, 'update')]
class UpdateTest extends TestCase
{
    use TestTrait;

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $template = CallCommentTemplate::factory()->create();

        $this->service->update(
            $template->id,
            new Name($name = 'new-name'),
            new Text($text = 'new-text')
        );

        $this->assertDatabaseHas(CallCommentTemplate::getTableName(), [
            'id' => $template->id,
            'name' => $name,
            'text' => $text,
        ]);
    }
}
