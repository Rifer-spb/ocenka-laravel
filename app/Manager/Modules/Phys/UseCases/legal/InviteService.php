<?php

namespace App\Manager\Modules\Phys\UseCases\legal;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\Legal\LegalEmployee;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Mails\Invite\SendInviteMail;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\CreateRequest;

class InviteService
{
    /**
     * @throws \Throwable
     */
    public function create(int $userId, CreateRequest $request): void
    {
        $phys = Phys::findOrFail($userId);
        $legal = Legal::getByUsername($request->email);

        $hasInvite = LegalEmployee::hasByPhysAndLegal($phys, $legal);

        if ($hasInvite) {
            throw new \DomainException('Заявка с указанным юр.лицом уже существует.');
        }

        $invite = LegalEmployee::createByPhys($phys, $legal);
        $this->sendInviteEmail($invite);
    }

    public function reSend(int $inviteId, int $userId): void
    {
        $phys = Phys::findOrFail($userId);
        $invite = LegalEmployee::getWaitByIdForPhys($inviteId, $phys);

        $this->sendInviteEmail($invite);
    }

    /**
     * @param int $inviteId
     * @param int $userId
     * @return void
     * @throws \Throwable
     */
    public function cancel(int $inviteId, int $userId): void
    {
        $phys = Phys::findOrFail($userId);
        $invite = LegalEmployee::getWaitByIdForPhys($inviteId, $phys);

        $invite->deleteOrFail();
    }

    private function sendInviteEmail(LegalEmployee $invite): void
    {
        $mail = new SendInviteMail(
            $invite->legal->role,
            $invite->legal->email
        );

        SendMailJob::dispatch($mail);
    }
}
