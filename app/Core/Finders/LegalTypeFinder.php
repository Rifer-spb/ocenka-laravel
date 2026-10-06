<?php

namespace App\Core\Finders;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\LegalType;
use Illuminate\Database\Eloquent\Collection;

class LegalTypeFinder
{
    public static function getAll(): Collection
    {
        return LegalType::orderBy('name')->get();
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
