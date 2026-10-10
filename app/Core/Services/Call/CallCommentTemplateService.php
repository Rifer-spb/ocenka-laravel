<?php

namespace App\Core\Services\Call;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Finders\CallCommentTemplateFinder;
use App\Core\Finders\LegalFinder;

class CallCommentTemplateService
{
    /**
     * @throws \Throwable
     */
    public function create(int $legalId, string $name, string $text): void
    {
        $legal = LegalFinder::getById($legalId);

        CallCommentTemplate::createNew($legal, $name, $text);
    }

    /**
     * @param int $templateId
     * @param string $name
     * @param string $text
     * @return void
     * @throws \Throwable
     */
    public function update(int $templateId, string $name, string $text): void
    {
        $template = CallCommentTemplateFinder::getById($templateId);
        $template->edit($name, $text);
        $template->saveOrFail();
    }
}
