<?php

namespace App\Manager\UseCases\Phys\Invite;

use App\Core\Finder\User\LegalFinder;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\User\Phys\Phys;
use App\Core\ValueObjects\Email;
use App\Manager\Services\InviteService;

class CreateUseCase
{
    public function __construct(
        private InviteService $inviteService,
    ) {}

    /**
     * @param Phys $phys
     * @param Email $email
     * @return void
     * @throws \Exception
     */
    public function execute(Phys $phys, Email $email): void
    {
        $legal = LegalFinder::getByUsername($email->getValue());
        $this->inviteService->create($phys, $legal, InviteForWho::LEGAL);
    }
}
