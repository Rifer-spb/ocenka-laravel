<?php

namespace App\Core\ReadServices;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Finders\CallCommentTemplateFinder;

class CallCommentTemplateReadService
{
    public function getAllByLegal(int $legalId): array
    {
        $templates = CallCommentTemplateFinder::getAllByLegal($legalId);

        return $templates->map(fn (CallCommentTemplate $t) => [
            'id' => $t->id,
            'name' => $t->name,
            'text' => $t->text,
        ])->all();
    }
}
