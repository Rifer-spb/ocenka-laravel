<?php

namespace App\Manager\UseCases\Legal\Invite;

use App\Core\Finder\User\PhysFinder;
use App\Core\Models\Invite\ForWho;
use App\Core\Models\User\Legal\Legal;
use App\Core\ValueObjects\Email;
use App\Manager\Services\InviteService;

class CreateUseCase
{
    public function __construct(
        private InviteService $inviteService,
    ) {}

    /**
     * @param Legal $legal
     * @param Email $email
     * @return void
     * @throws \Exception
     */
    public function execute(Legal $legal, Email $email): void
    {
        $phys = PhysFinder::getByUsername($email->getValue());
        $this->inviteService->create($phys, $legal, ForWho::PHYS);
    }
}
