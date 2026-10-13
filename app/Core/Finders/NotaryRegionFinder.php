<?php

namespace App\Core\Finders;

use App\Core\Entities\Notary\NotaryRegion;

class NotaryRegionFinder
{
    public static function getAll(): array
    {
        return NotaryRegion::all()->all();
    }

    public static function getList(): array
    {
        return collect(self::getAll())->pluck('name', 'id')->all();
    }

    public static function findByGroupName(string $name): ?NotaryRegion
    {
        return NotaryRegion::where('group_name', $name)->first();
    }
}
