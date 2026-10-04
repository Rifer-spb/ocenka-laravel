<?php

namespace App\Core\Services;

use App\Core\Finder\EmployeeFinder;
use App\Core\Finder\User\LegalFinder;
use App\Core\Finder\User\PhysFinder;
use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\ValueObjects\Email;
use App\Manager\Jobs\Invite\SendInviteMailJob;
use Illuminate\Support\Facades\DB;

class InviteService
{
    public function createForPhys(int $legalId, Email $email): void
    {
        $legal = Legal::findOrFail($legalId);
        $phys = PhysFinder::getByUsername($email->getValue());

        $this->create($legal, $phys, InviteForWho::PHYS);
    }

    public function createForLegal(int $legalId, Email $email): void
    {
        $phys = Phys::findOrFail($legalId);
        $legal = LegalFinder::getByUsername($email->getValue());

        $this->create($legal, $phys, InviteForWho::LEGAL);
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function cancel(int $inviteId): void
    {
        $invite = $this->getInvite($inviteId);

        if (! $invite->isWait()) {
            throw new \DomainException('Заявка должна быть в статусе ожидания.');
        }

        $invite->deleteOrFail();
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function close(int $inviteId): void
    {
        $invite = $this->getInvite($inviteId);

        DB::transaction(function () use ($invite) {
            $invite->complete();
            $invite->saveOrFail();

            $employee = EmployeeFinder::getByInvite($invite);
            $employee->deleteOrFail();
        });
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function confirm(int $inviteId): void
    {
        $invite = $this->getInvite($inviteId);

        DB::transaction(function () use ($invite) {
            $invite->confirm();
            $invite->saveOrFail();

            Employee::createNew($invite);
        });
    }

    public function reSendEmail(int $inviteId): void
    {
        $invite = $this->getInvite($inviteId);

        if (! $invite->isWait()) {
            throw new \DomainException('Заявка не в статуса ожидания.');
        }

        $this->sendEmail($invite);
    }

    private function create(Legal $legal, Phys $phys, InviteForWho $for): void
    {
        $invite = Invite::createNew($phys, $legal, $for);
        $this->sendEmail($invite);
    }

    private function sendEmail(Invite $invite): void
    {
        SendInviteMailJob::dispatch($invite);
    }

    private function getInvite(int $inviteId): Invite
    {
        return Invite::findOrFail($inviteId);
    }
}
