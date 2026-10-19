<?php

namespace App\Core\ReadServices;

use App\Core\Entities\LegalType;

class LegalTypeReadService
{
    public function getAll(): array
    {
        return LegalType
            ::orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->all();
    }
}
