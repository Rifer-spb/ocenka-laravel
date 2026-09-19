<?php

namespace App\Core\Finder\Notary;

use App\Core\Models\Notary\NotaryRegion;

class NotaryRegionFinder
{
    public static function getList(): array
    {
        return NotaryRegion::pluck('name', 'id')->all();
    }

    public static function findByGroupName(string $name): ?NotaryRegion
    {
        return NotaryRegion::where('group_name', $name)->first();
    }
}
