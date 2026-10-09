<?php

namespace App\Core\Services\Mango;

class ArgumentValidator
{
    public static function validateEntryId(string $entryId): void
    {
        if (empty($entryId)) {
            throw new \InvalidArgumentException('Идентификатор звонка не передан.');
        }
    }

    public static function validateFrom(int $from): void
    {
        if ($from <= 0) {
            throw new \InvalidArgumentException('Входящий номер звонка не передан.');
        }
    }

    public static function validateTo(int $to): void
    {
        if ($to <= 0) {
            throw new \InvalidArgumentException('Не передан номер на который идет звонок.');
        }
    }

    public static function validateTimestamp(int $timestamp): void
    {
        if ($timestamp <= 0) {
            throw new \InvalidArgumentException('Время звонка не передано.');
        }
    }
}
