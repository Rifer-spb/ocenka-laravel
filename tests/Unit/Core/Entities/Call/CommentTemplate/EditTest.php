<?php

namespace Tests\Unit\Core\Entities\Call\CommentTemplate;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\Call\CommentTemplate\Name;
use App\Core\Entities\Call\CommentTemplate\Text;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(CallCommentTemplate::class, 'edit')]
class EditTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $template = CallCommentTemplate::factory()->create();

        $template->edit(
            new Name($name = 'new-name'),
            new Text($text = 'new-text'),
        );

        $this->assertEquals($name, $template->name);
        $this->assertEquals($text, $template->text);
    }
}
