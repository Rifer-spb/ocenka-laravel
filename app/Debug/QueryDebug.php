<?php

namespace App\Debug;

use Illuminate\Support\Facades\DB;

class QueryDebug
{
    public static function start(): void
    {
        DB::enableQueryLog();
    }

    public static function dump(): void
    {
        $queries = DB::getQueryLog();
        dump([
            'total' => count($queries),
            'queries' => $queries
        ]);
    }

    public static function dd(): void
    {
        $queries = DB::getQueryLog();
        dd([
            'total' => count($queries),
            'queries' => $queries
        ]);
    }

    public static function count(): int
    {
        return count(DB::getQueryLog());
    }
}
