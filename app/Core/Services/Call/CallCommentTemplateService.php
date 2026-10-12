<?php

namespace App\Core\Services\Call;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\Call\CommentTemplate\Name;
use App\Core\Entities\Call\CommentTemplate\Text;
use App\Core\Finders\CallCommentTemplateFinder;
use App\Core\Finders\LegalFinder;

class CallCommentTemplateService
{
    /**
     * @throws \Throwable
     */
    public function create(int $legalId, Name $name, Text $text): void
    {
        $legal = LegalFinder::getById($legalId);

        CallCommentTemplate::createNew($legal, $name, $text);
    }

    /**
     * @param int $templateId
     * @param Name $name
     * @param Text $text
     * @return void
     * @throws \Throwable
     */
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
    public function delete(int $templateId): void
    {
        $template = CallCommentTemplateFinder::getById($templateId);
        $template->deleteOrFail();
    }
}
