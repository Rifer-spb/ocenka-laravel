<?php

namespace App\Core\Services\Call;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\Call\CommentTemplate\Name;
use App\Core\Entities\Call\CommentTemplate\Text;
use App\Core\Finders\CallCommentTemplateFinder;
use App\Core\Finders\LegalFinder;
use Tests\Integration\Core\Services\Call\CommentTemplate\CreateTest;
use Tests\Integration\Core\Services\Call\CommentTemplate\DeleteTest;
use Tests\Integration\Core\Services\Call\CommentTemplate\UpdateTest;

class CallCommentTemplateService
{
    /**
     * @throws \Throwable
     */
    #[TestClass(CreateTest::class)]
    public function create(int $legalId, Name $name, Text $text): CallCommentTemplate
    {
        $legal = LegalFinder::getById($legalId);

        return CallCommentTemplate::createNew($legal, $name, $text);
    }

    /**
     * @param int $templateId
     * @param Name $name
     * @param Text $text
     * @return void
     * @throws \Throwable
     */
    #[TestClass(UpdateTest::class)]
    public function update(int $templateId, Name $name, Text $text): void
    {
        $template = CallCommentTemplateFinder::getById($templateId);
        $template->edit($name, $text);
        $template->saveOrFail();
    }

    /**
     * @param int $templateId
     * @return void
     * @throws \Throwable
     */
    #[TestClass(DeleteTest::class)]
    public function delete(int $templateId): void
    {
        $template = CallCommentTemplateFinder::getById($templateId);
        $template->deleteOrFail();
    }
}
