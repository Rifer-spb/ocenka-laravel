<?php

namespace App\Manager\UseCases\Phys\Invite;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Finders\InviteFinder;
use App\Manager\Services\InviteService;

class ResendUseCase
{
    public function __construct(
        private InviteService $inviteService,
    ) {}

    /**
     * @param Phys $phys
     * @param int $inviteId
     * @return void
     * @throws \Exception
     */
    public function execute(Phys $phys, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndPhys($inviteId, $phys);
        $this->inviteService->sendEmail($invite);
    }
}
