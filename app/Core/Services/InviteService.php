<?php

namespace App\Core\Services;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Employee\Employee;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Finders\EmployeeFinder;
use App\Core\Finders\InviteFinder;
use App\Core\Finders\LegalFinder;
use App\Core\Finders\PhysFinder;
use App\Core\ValueObjects\Email;
use App\Manager\Jobs\Invite\SendInviteMailJob;
use Illuminate\Support\Facades\DB;
use Tests\Integration\Core\Services\Invite\CreateForPhysTest;
use Tests\Integration\Core\Services\Invite\CreateForLegalTest;
use Tests\Integration\Core\Services\Invite\CancelTest;
use Tests\Integration\Core\Services\Invite\CloseTest;
use Tests\Integration\Core\Services\Invite\ConfirmTest;
use Tests\Integration\Core\Services\Invite\ResendTest;

class InviteService
{
    /**
     * @throws \Throwable
     */
    #[TestClass(CreateForPhysTest::class)]
    public function createForPhys(int $legalId, Email $email): void
    {
        $legal = LegalFinder::getById($legalId);
        $phys = PhysFinder::getByUsername($email->getValue());

        $this->create($legal, $phys, InviteForWho::PHYS);
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(CreateForLegalTest::class)]
    public function createForLegal(int $physId, Email $email): void
    {
        $phys = PhysFinder::getById($physId);
        $legal = LegalFinder::getByUsername($email->getValue());

        $this->create($legal, $phys, InviteForWho::LEGAL);
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    #[TestClass(CancelTest::class)]
    public function cancel(int $inviteId): void
    {
        $invite = InviteFinder::getById($inviteId);

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
    #[TestClass(CloseTest::class)]
    public function close(int $inviteId): void
    {
        $invite = InviteFinder::getById($inviteId);

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
    #[TestClass(ConfirmTest::class)]
    public function confirm(int $inviteId): void
    {
        $invite = InviteFinder::getById($inviteId);

        DB::transaction(function () use ($invite) {
            $invite->confirm();
            $invite->saveOrFail();

            Employee::createNew($invite);
        });
    }

    #[TestClass(ResendTest::class)]
    public function reSendEmail(int $inviteId): void
    {
        $invite = InviteFinder::getById($inviteId);

        if (! $invite->isWait()) {
            throw new \DomainException('Заявка не в статуса ожидания.');
        }

        $this->sendEmail($invite);
    }

    /**
     * @throws \Throwable
     */
    private function create(Legal $legal, Phys $phys, InviteForWho $for): void
    {
        $invite = Invite::createNew($phys, $legal, $for);
        $this->sendEmail($invite);
    }

    private function sendEmail(Invite $invite): void
    {
        SendInviteMailJob::dispatch($invite);
    }
}
