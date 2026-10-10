<?php

namespace App\Core\Entities\Call\CommentTemplate;

use App\Core\Attributes\TestClass;
use App\Core\Entities\AbstractEntity;
use App\Core\Entities\User\Legal\Legal;
use Database\Factories\Core\Entities\Call\CommentTemplate\CallCommentTemplateFactory;
use Tests\Unit\Core\Entities\Call\CommentTemplate\CreateTest;
use Tests\Unit\Core\Entities\Call\CommentTemplate\EditTest;

/**
 * @property int $id
 * @property int $legal_id
 * @property string $name
 * @property string $text
 *
 * @method static CallCommentTemplateFactory factory()
 */
class CallCommentTemplate extends AbstractEntity
{
    /**
     * @throws \Throwable
     */
    #[TestClass(CreateTest::class)]
    public static function createNew(Legal $legal, Name $name, Text $text): self
    {
        $model = new self();
        $model->legal_id = $legal->id;
        $model->name = $name->getValue();
        $model->text = $text->getValue();
        $model->saveOrFail();

        return $model;
    }

    #[TestClass(EditTest::class)]
    public function edit(Name $name, Text $text): void
    {
        $this->name = $name->getValue();
        $this->text = $text->getValue();
    }
}
