<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;

class UpdateDoReportUseCase
{
    public function execute(Legal $legal, int $inviteId, int $accessId): void
    {
        $invite = InviteFinder::getActiveByIdAndLegal($inviteId, $legal);
        $employee = EmployeeFinder::getByInvite($invite);
        $employee->switchDoReportAccess($accessId);
    }
}
