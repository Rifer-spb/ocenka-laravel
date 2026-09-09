<?php

namespace App\Manager\UseCases\Phys\Invite;

use App\Core\Models\User\Phys\Phys;
use App\Manager\Finders\InviteFinder;
use App\Manager\Services\InviteService;
use Illuminate\Support\Facades\DB;

class ConfirmUseCase
{
    public function __construct(
        private InviteService $inviteService,
    ) {}

    /**
     * @param Phys $phys
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     */
    public function execute(Phys $phys, int $inviteId): void
    {
        $invite = InviteFinder::getWaitByIdAndPhys($inviteId, $phys);
        DB::transaction(fn () => $this->inviteService->confirm($invite));
    }
}
