<?php

namespace Tests\Integration\Core\Services\Call;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\Call\CommentTemplate\Name;
use App\Core\Entities\Call\CommentTemplate\Text;
use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Services\Call\CallCommentTemplateService;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversMethod(CallCommentTemplateService::class,'create')]
class CreateTest extends AbstractTest
{
    /**
     * @throws \Throwable
     */
    public function testInvalidLegalId()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage('Юр.лицо не найдено.');

        $this->service->create(999, new Name('name'), new Text('text'));
    }

    /**
     * @throws \Throwable
     */
    public function testSuccess()
    {
        $legal = Legal::factory()->create();
        $template = $this->service->create(
            $legal->id,
            new Name($name = 'name'),
            new Text($text = 'text')
        );

        $this->assertDatabaseHas(CallCommentTemplate::getTableName(), [
            'id' => $template->id,
            'legal_id' => $legal->id,
            'name' => $name,
            'text' => $text,
        ]);
    }
}
