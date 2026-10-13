<?php

namespace Tests\Unit\Core\Entities\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\Call\CommentTemplate\Name;
use App\Core\Entities\Call\CommentTemplate\Text;
use App\Core\Entities\User\Legal\Legal;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(CallCommentTemplate::class, 'createNew')]
class CreateTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $legal = Legal::factory()->create();
        $template = CallCommentTemplate::createNew(
            $legal,
            new Name($name = 'template-name'),
            new Text($text = 'template-text'),
        );

        $this->assertEquals($legal->id, $template->legal_id);
        $this->assertEquals($name, $template->name);
        $this->assertEquals($text, $template->text);

        $this->assertDatabaseHas(CallCommentTemplate::getTableName(), [
            'id' => $template->id,
            'legal_id' => $legal->id,
            'name' => $name,
            'text' => $text,
        ]);
    }
}
