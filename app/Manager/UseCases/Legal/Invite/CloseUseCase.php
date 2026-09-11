<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Models\User\Legal\Legal;
use App\Manager\Finders\InviteFinder;
use App\Manager\Services\InviteService;
use Illuminate\Support\Facades\DB;

class CloseUseCase
{
    public function __construct(
        private InviteService $inviteService,
    ) {}

    /**
     * @param Legal $legal
     * @param int $inviteId
     * @return void
     * @throws \Throwable
     * @see \Integration\Manager\UseCases\Legal\Invite\CloseUseCaseTest
     */
    public function execute(Legal $legal, int $inviteId): void
    {
        $invite = InviteFinder::getActiveByIdAndLegal($inviteId, $legal);
        DB::transaction(fn () => $this->inviteService->close($invite));
    }
}
