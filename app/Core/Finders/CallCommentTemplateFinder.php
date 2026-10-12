<?php

namespace App\Core\Finders;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\EntityNotFoundException;

class CallCommentTemplateFinder
{
    public static function getById(int $id): CallCommentTemplate
    {
        $model = CallCommentTemplate::find($id);

        if (! $model) {
            throw new EntityNotFoundException('Шаблон комментария звонка не найден.');
        }

        return $model;
    }
}
