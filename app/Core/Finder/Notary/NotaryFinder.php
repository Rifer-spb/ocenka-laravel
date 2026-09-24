<?php

namespace App\Core\Finder\Notary;

use App\Core\Models\Notary\Notary;

class NotaryFinder
{
    public static function findByNotariatId(int $notariatId): ?Notary
    {
        return Notary::where('notariat_notary_id', $notariatId)->first();
    }
}
