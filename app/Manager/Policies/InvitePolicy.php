<?php

namespace App\Manager\Policies;

use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;

class InvitePolicy
{
    public function own(Legal|Phys $user, Invite $invite): bool
    {
        return match (true) {
            $user instanceof Legal => $invite->legal_id === $user->id,
            $user instanceof Phys => $invite->phys_id === $user->id,
            default => false,
        };
    }
}
