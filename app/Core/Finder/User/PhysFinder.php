<?php

namespace App\Core\Finder\User;

use App\Core\Models\User\Phys\Phys;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PhysFinder
{
    public static function getByUsername(string $username): Phys
    {
        $user = Phys::where('username', $username)->first();

        if (! $user) {
            throw new ModelNotFoundException("Физ.лицо с username {$username} не найдено.");
        }

        return $user;
    }
}
