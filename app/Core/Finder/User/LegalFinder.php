<?php

namespace App\Core\Finder\User;

use App\Core\Models\User\Legal\Legal;
use App\Exceptions\EntityNotFoundException;

class LegalFinder
{
    public static function getByUsername(string $username): Legal
    {
        $user = Legal::where('username', $username)->first();

        if (! $user) {
            throw new EntityNotFoundException("Юр.лицо с username {$username} не найдено.");
        }

        return $user;
    }
}
