<?php

namespace App\Core\Services;

use App\Core\Finder\EmployeeFinder;
use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Jobs\Invite\SendInviteMailJob;
use Illuminate\Support\Facades\DB;

class InviteService
{
    public function create(Legal $legal, Phys $phys, InviteForWho $for): void
    {
        $invite = Invite::createNew($phys, $legal, $for);
        $this->sendEmail($invite);
    }

    /**
     * @param Invite $invite
     * @return void
     * @throws \Throwable
     */
    public function cancel(Invite $invite): void
    {
        if (! $invite->isWait()) {
            throw new \DomainException('Заявка должна быть в статусе ожидания.');
        }

        $invite->deleteOrFail();
    }

    /**
     * @param Invite $invite
     * @return void
     * @throws \Throwable
     */
    public function close(Invite $invite): void
    {
        DB::transaction(function () use ($invite) {
            $invite->complete();
            $invite->saveOrFail();

            $employee = EmployeeFinder::getByInvite($invite);
            $employee->deleteOrFail();
        });
    }

    /**
     * @param Invite $invite
     * @return void
     * @throws \Throwable
     */
    public function confirm(Invite $invite): void
    {
        DB::transaction(function () use ($invite) {
            $invite->confirm();
            $invite->saveOrFail();

            Employee::createNew($invite);
        });
    }

    public function reSendEmail(Invite $invite): void
    {
        if (! $invite->isWait()) {
            throw new \DomainException('Заявка не в статуса ожидания.');
        }

        $this->sendEmail($invite);
    }

    private function sendEmail(Invite $invite): void
    {
        SendInviteMailJob::dispatch($invite);
    }
}
