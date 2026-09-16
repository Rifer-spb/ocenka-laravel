<?php

namespace App\Core\Finder\Notary;

use App\Core\Models\Notary\NotaryRegion;

class NotaryRegionFinder
{
    public static function getList(): array
    {
        return NotaryRegion::pluck('name', 'id')->all();
    }
}
