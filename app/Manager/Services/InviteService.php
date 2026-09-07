<?php

namespace App\Manager\Services;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Jobs\Invite\SendInviteMailJob;
use App\Manager\Mails\Invite\SendInviteMail;

class InviteService
{
    /**
     * @param Phys $phys
     * @param Legal $legal
     * @param InviteForWho $for
     * @return Invite
     *
     * Тесты @see \Integration\Manager\Services\InviteCreateTest
     */
    public function create(Phys $phys, Legal $legal, InviteForWho $for): Invite
    {
        $invite = Invite::createNew($phys, $legal, $for);
        $this->sendEmail($invite);
        return $invite;
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
    public function confirm(Invite $invite): void
    {
        $invite->confirm();
        $invite->saveOrFail();

        Employee::createNew($invite);
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

        $employee = EmployeeFinder::getByInvite($invite);
        $employee->deleteOrFail();
    }
}
