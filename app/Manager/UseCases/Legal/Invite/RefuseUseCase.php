<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\InviteFinder;
use App\Core\Models\User\Legal\Legal;

class RefuseUseCase
{
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndLegal($inviteId, $legal);
        $invite->deleteOrFail();
    }
}
