<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;
use App\Core\Finder\EmployeeFinder;

class UpdateDoReportUseCase
{
    /**
     * @param Legal $legal
     * @param int $inviteId
     * @param int $accessId
     * @return void
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\UpdateDoReportUseCaseTest
     */
    public function execute(Legal $legal, int $inviteId, int $accessId): void
    {
        $invite = InviteFinder::getActiveByIdAndLegal($inviteId, $legal);
        $employee = EmployeeFinder::getByInvite($invite);
        $employee->switchDoReportAccess($accessId);
    }
}
