<?php

namespace App\Manager\Modules\Phys\UseCases;

use App\Core\Models\Invite\Invite;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Manager\UseCases\AbstractInviteService;

class InviteService extends AbstractInviteService
{
    /**
     * @throws \Throwable
     */
    public function create(int $userId, string $email): void
    {
        $phys = Phys::findOrFail($userId);
        $legal = Legal::getByUsername($email);

        $hasWaitInvite = Invite::hasWait($phys, $legal);

        if ($hasWaitInvite) {
            throw new \DomainException('Заявка с указанным юр.лицом уже существует.');
        }

        $hasActive = Invite::hasActive($phys, $legal);

        if ($hasActive) {
            throw new \DomainException('Связь с указанным юр.лицом уже установлена.');
        }

        Invite::createByPhys($phys, $legal);
        $this->sendInviteEmail($legal);
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Exception
     */
    public function reSend(int $inviteId): void
    {
        $invite = Invite::getWaitById($inviteId);
        $this->sendInviteEmail($invite->legal);
    }
}
