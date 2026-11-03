<?php

namespace App\Core\Finders;

use App\Core\Entities\Call\Call;
use App\Core\Entities\EntityNotFoundException;

class CallFinder
{
    public static function hasByMangoId(string $mangoId): bool
    {
        return Call::where('mango_call_id', $mangoId)->exists();
    }

    public static function getByMangoId(string $mangoId): ?Call
    {
        $call = Call::where('mango_call_id', $mangoId)->first();

        if (! $call) {
            throw new EntityNotFoundException('Звонок не найден.');
        }

        return $call;
    }
}
