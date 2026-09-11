<?php

namespace App\Manager\UseCases\Phys\Invite;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Finders\InviteFinder;

class CancelUseCase
{
    /**
     * @param Phys $phys
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     * @see \Integration\Manager\UseCases\Phys\Invite\CancelUseCaseTest
     */
    public function execute(Phys $phys, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndPhys($inviteId, $phys);
        $invite->deleteOrFail();
    }
}
