<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;

class CancelUseCase
{
    /**
     * @param Legal $legal
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\CancelUseCaseTest
     */
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndLegal($inviteId, $legal);
        $invite->deleteOrFail();
    }
}
