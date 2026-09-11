<?php

namespace App\Core\Finder\User;

use App\Core\Models\EntityNotFoundException;
use App\Core\Models\User\Legal\Legal;

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
