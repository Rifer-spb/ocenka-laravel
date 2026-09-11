<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;
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
     *
     * @see \Integration\Manager\UseCases\Legal\Invite\ResendUseCaseTest
     */
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndLegal($inviteId, $legal);
        $this->inviteService->sendEmail($invite);
    }
}
