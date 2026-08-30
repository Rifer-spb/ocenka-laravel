<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\InviteFinder;
use App\Core\Models\User\Legal\Legal;
use App\Core\Services\InviteService;
use Illuminate\Support\Facades\DB;

class RevokeUseCase
{
    public function __construct(
        private InviteService $inviteService,
    ) {}

    /**
     * @param Legal $legal
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndLegal($inviteId, $legal);
        DB::transaction(fn () => $this->inviteService->revoke($invite));
    }
}
