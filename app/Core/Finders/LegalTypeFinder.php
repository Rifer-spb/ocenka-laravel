<?php

namespace App\Core\Finders;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\LegalType;

class LegalTypeFinder
{
    public static function getAll(): array
    {
        return LegalType::all()->all();
    }

    public static function getById(int $id): LegalType
    {
        $type = LegalType::find($id);

        if (! $type) {
            throw new EntityNotFoundException('Тип юр лица не найден.');
        }

        return $type;
    }
}
