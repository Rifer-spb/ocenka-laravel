<?php

namespace App\Core\ReadServices;

use App\Core\Finders\NotaryRegionFinder;

class NotaryRegionReadService
{
    public function getList(): array
    {
        $regions = NotaryRegionFinder::getAll();

        return collect($regions)->pluck('name', 'id')->all();
    }
}
