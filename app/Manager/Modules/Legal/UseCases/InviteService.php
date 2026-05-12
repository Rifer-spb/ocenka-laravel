<?php

namespace App\Manager\Modules\Legal\UseCases;

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
        $legal = Legal::findOrFail($userId);
        $phys = Phys::getByUsername($email);

        $hasWaitInvite = Invite::hasWait($phys, $legal);

        if ($hasWaitInvite) {
            throw new \DomainException('Заявка с указанным сотрудником уже существует.');
        }

        $hasActive = Invite::hasActive($phys, $legal);

        if ($hasActive) {
            throw new \DomainException('Связь с указанным сотрудником уже установлена.');
        }

        Invite::createByLegal($legal, $phys);
        $this->sendInviteEmail($phys);
    }

    /**
     * @param int $inviteId
     * @return void
     * @throws \Exception
     */
    public function reSend(int $inviteId): void
    {
        $invite = Invite::getWaitById($inviteId);
        $this->sendInviteEmail($invite->phys);
    }
}
