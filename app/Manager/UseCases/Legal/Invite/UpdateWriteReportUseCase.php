<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Finder\InviteFinder;
use App\Core\Models\User\Legal\Legal;

class UpdateWriteReportUseCase
{

    /**
     * @param Legal $legal
     * @param int $inviteId
     * @param int $accessId
     * @return void
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\UpdateWriteReportUseCaseTest
     */
    public function execute(Legal $legal, int $inviteId, int $accessId): void
    {
        $invite = InviteFinder::getActiveByIdAndLegal($inviteId, $legal);
        $employee = EmployeeFinder::getByInvite($invite);
        $employee->switchWriteReportAccess($accessId);
    }
}
