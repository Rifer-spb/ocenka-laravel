<?php

namespace App\Core\Models\User;

use App\Core\Models\User\Client\Client;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Notary\Notary;
use App\Core\Models\User\Phys\Phys;

class UserFactory
{
    public function create(string $role): string
    {
        return match ($role) {
            Role::PHYS->value => Phys::class,
            Role::LEGAL->value => Legal::class,
            Role::CLIENT->value => Client::class,
            Role::NOTARY->value => Notary::class,
            default => throw new \InvalidArgumentException('Роль не определена.'),
        };
    }
}
