<?php

namespace App\Core\Finders;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\EntityNotFoundException;
use Illuminate\Support\Collection;

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

    public static function getAllByLegal(int $legalId): Collection
    {
        return CallCommentTemplate::where('legal_id', $legalId)->orderBy('id')->get();
    }
}
