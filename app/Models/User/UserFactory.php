<?php

namespace App\Models\User;

use App\Models\User\Client\Client;
use App\Models\User\Legal\Legal;
use App\Models\User\Notary\Notary;
use App\Models\User\Phys\Phys;

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
