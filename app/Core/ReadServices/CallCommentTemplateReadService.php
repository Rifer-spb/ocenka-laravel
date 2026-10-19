<?php

namespace App\Core\ReadServices;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;

class CallCommentTemplateReadService
{
    public function getAllByLegal(int $legalId): array
    {
        $callback = fn (CallCommentTemplate $t) => [
            'id' => $t->id,
            'name' => $t->name,
            'text' => $t->text,
        ];

        return CallCommentTemplate::
            select(['id', 'name', 'text'])
            ->where('legal_id', $legalId)
            ->orderBy('id')
            ->get()
            ->map($callback)
            ->all();
    }
}
