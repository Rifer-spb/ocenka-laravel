<?php

namespace App\Core\Finders;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Legal\Legal;

class LegalFinder
{
    public static function getById(int $id): Legal
    {
        $legal = Legal::find($id);

        self::validateNotFound($legal);

        return $legal;
    }

    public static function getByUsername(string $username): Legal
    {
        $user = Legal::where('username', $username)->first();

        if (! $user) {
            throw new EntityNotFoundException("Юр.лицо с username {$username} не найдено.");
        }

        return $user;
    }

    public static function getByPhone(int $phone): Legal
    {
        $legal = Legal::whereHas('phones', fn ($q) => $q->where('phone', $phone))->first();

        self::validateNotFound($legal);

        return $legal;
    }

    private static function validateNotFound(?Legal $legal): void
    {
        if (! $legal) {
            throw new EntityNotFoundException('Юр.лицо не найдено.');
        }
    }
}
