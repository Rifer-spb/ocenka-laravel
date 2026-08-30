<?php

namespace App\Manager\Services;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\ForWho;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Jobs\Invite\SendInviteMailJob;

class InviteService
{
    public function create(Phys $phys, Legal $legal, ForWho $for): Invite
    {
        $invite = Invite::createNew($phys, $legal, $for);
        $this->sendEmail($invite);
        return $invite;
    }

    /**
     * @param Invite $invite
     * @return void
     * @throws \Throwable
     */
    public function confirm(Invite $invite): void
    {
        $invite->confirm();
        $invite->saveOrFail();

        Employee::createNew($invite);
    }

    public function sendEmail(Invite $invite): void
    {
        SendInviteMailJob::dispatch($invite);
    }

    /**
     * @param Invite $invite
     * @return void
     * @throws \Throwable
     */
    public function revoke(Invite $invite): void
    {
        $invite->complete();
        $invite->saveOrFail();

        EmployeeFinder::getByInvite($invite)->deleteOrFail();
    }
}
