<?php

namespace App\Core\ReadServices;

use App\Core\Finders\LegalTypeFinder;

class LegalTypeReadService
{
    public function getList(): array
    {
        return LegalTypeFinder::getAll()->pluck('name', 'id')->all();
    }
}
