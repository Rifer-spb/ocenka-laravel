<?php

namespace App\Core\Services\Mango;

class MangoService
{
    public function appeared(string $entryId, int $from, int $to, int $timestamp): void
    {
        ArgumentValidator::validateEntryId($entryId);
        ArgumentValidator::validateFrom($from);
        ArgumentValidator::validateTo($to);
        ArgumentValidator::validateTimestamp($timestamp);


    }

    public function connected()
    {

    }

    public function summary()
    {

    }
}
