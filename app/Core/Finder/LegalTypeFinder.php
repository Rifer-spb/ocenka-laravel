<?php

namespace App\Core\Finder;

use App\Core\Models\LegalType;

class LegalTypeFinder
{
    public static function getList(): array
    {
        return LegalType::pluck('name', 'id')->all();
    }
}
