<?php

namespace App\Core\Finder\User;

use App\Core\Models\User\Legal\Legal;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LegalFinder
{
    public static function getByUsername(string $username): Legal
    {
        $user = Legal::where('username', $username)->first();

        if (! $user) {
            throw new ModelNotFoundException("Юр.лицо с username {$username} не найдено.");
        }

        return $user;
    }
}
