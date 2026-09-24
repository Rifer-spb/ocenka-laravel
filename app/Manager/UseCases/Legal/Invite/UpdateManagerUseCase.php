<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Finder\InviteFinder;
use App\Core\Models\User\Legal\Legal;

class UpdateManagerUseCase
{
    /**
     * @param Legal $legal
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\UpdateManagerUseCaseTest
     */
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getActiveByIdAndLegal($inviteId, $legal);
        $employee = EmployeeFinder::getByInvite($invite);
        $employee->switchIsManagerAccess();
        $employee->saveOrFail();
    }
}
