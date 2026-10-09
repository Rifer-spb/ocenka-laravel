<?php

namespace App\Core\Finders;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\Phys\Phys;

class PhysFinder
{
    public static function getById(int $id): Phys
    {
        $phys = Phys::find($id);

        if (! $phys) {
            throw new EntityNotFoundException("Физ.лицо не найдено.");
        }

        return $phys;
    }

    public static function getByUsername(string $username): Phys
    {
        $phys = Phys::where('username', $username)->first();

        if (! $phys) {
            throw new EntityNotFoundException("Физ.лицо с username {$username} не найдено.");
        }

        return $phys;
    }
}
