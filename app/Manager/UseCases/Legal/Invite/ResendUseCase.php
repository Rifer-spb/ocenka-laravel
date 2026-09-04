<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\InviteFinder;
use App\Core\Models\User\Legal\Legal;
use App\Manager\Services\InviteService;

class ResendUseCase
{
    public function __construct(
        private InviteService $inviteService,
    ) {}

    /**
     * @param Legal $legal
     * @param int $inviteId
     * @return void
     * @throws \Exception
     */
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndLegal($inviteId, $legal);
        $this->inviteService->sendEmail($invite);
    }
}
