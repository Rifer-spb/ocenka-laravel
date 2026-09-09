<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;

class RefuseUseCase
{
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndLegal($inviteId, $legal);
        $invite->deleteOrFail();
    }
}
