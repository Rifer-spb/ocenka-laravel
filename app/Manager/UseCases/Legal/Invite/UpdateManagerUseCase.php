<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;

class UpdateManagerUseCase
{
    /**
     * @param Legal $legal
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getActiveByIdAndLegal($inviteId, $legal);
        $employee = EmployeeFinder::getByInvite($invite);
        $employee->switchIsManagerAccess();
        $employee->saveOrFail();
    }
}
