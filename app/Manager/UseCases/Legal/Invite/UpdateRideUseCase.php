<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Finder\InviteFinder;
use App\Core\Models\User\Legal\Legal;

class UpdateRideUseCase
{
    /**
     * @param Legal $legal
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\UpdateRideUseCaseTest
     */
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getActiveByIdAndLegal($inviteId, $legal);
        $employee = EmployeeFinder::getByInvite($invite);
        $employee->switchRideAccess();
        $employee->saveOrFail();
    }
}
