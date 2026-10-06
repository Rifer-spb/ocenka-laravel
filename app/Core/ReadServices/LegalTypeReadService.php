<?php

namespace App\Core\ReadServices;

use App\Core\Finders\LegalTypeFinder;

class LegalTypeReadService
{
    public function getList(): array
    {
        $types = LegalTypeFinder::getAll();

        return collect($types)->pluck('name', 'id')->all();
    }
}
