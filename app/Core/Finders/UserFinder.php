<?php

namespace App\Core\Finders;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\User\User;

class UserFinder
{
    public static function getById(int $id): User
    {
        $user = User::find($id);

        if (! $user) {
            throw new EntityNotFoundException("Пользователь не найден.");
        }

        return $user;
    }
}
