<?php

namespace App\Manager\UseCases\Phys\Invite;

use App\Core\Finder\InviteFinder;
use App\Core\Models\User\Phys\Phys;

class RefuseUseCase
{
    public function execute(Phys $phys, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndPhys($inviteId, $phys);
        $invite->deleteOrFail();
    }
}
