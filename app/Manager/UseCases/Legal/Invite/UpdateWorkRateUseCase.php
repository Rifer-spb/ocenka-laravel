<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;

class UpdateWorkRateUseCase
{
    /**
     * @param Legal $legal
     * @param int $inviteId
     * @param int $value
     * @return void
     * @throws \Throwable
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\UpdateWorkRateUseCaseTest
     */
    public function execute(Legal $legal, int $inviteId, int $value): void
    {
        $invite = InviteFinder::getActiveByIdAndLegal($inviteId, $legal);
        $employee = EmployeeFinder::getByInvite($invite);
        $employee->work_rate = $value;
        $employee->saveOrFail();
    }
}
