<?php

namespace App\Core\Finders;

use App\Core\Entities\Call\Call;

class CallFinder
{
    public static function hasByMangoId(string $mangoId): bool
    {
        return Call::where('mango_call_id', $mangoId)->exists();
    }
}
