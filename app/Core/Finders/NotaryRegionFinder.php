<?php

namespace App\Core\Finders;

use App\Core\Entities\Notary\NotaryRegion;

class NotaryRegionFinder
{
    public static function findByGroupName(string $name): ?NotaryRegion
    {
        return NotaryRegion::where('group_name', $name)->first();
    }
}
