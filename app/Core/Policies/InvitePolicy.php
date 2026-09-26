<?php

namespace App\Core\Policies;

use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Role;
use App\Core\Models\User\User;

class InvitePolicy
{
    public function belongsTo(User $user, Invite $invite): bool
    {
        return match (true) {
            $user->role == Role::LEGAL->value => $invite->legal_id === $user->id,
            $user->role == Role::PHYS->value => $invite->phys_id === $user->id,
        };
    }
}
