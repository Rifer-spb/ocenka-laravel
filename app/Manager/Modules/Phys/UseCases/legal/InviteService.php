<?php

namespace App\Manager\Modules\Phys\UseCases\legal;

use App\Core\Models\Legal\LegalEmployee;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\CreateRequest;

class InviteService
{
    /**
     * @throws \Throwable
     */
    public function create(int $userId, CreateRequest $request): void
    {
        $phys = Phys::findOrFail($userId);
        $legal = Legal::getByUsername($request->email);

        $hasInvite = LegalEmployee::hasByPhysAndLegal($phys, $legal);

        if ($hasInvite) {
            throw new \DomainException('Заявка с указанным юр.лицом уже существует.');
        }

        LegalEmployee::createByPhys($phys, $legal);
    }
}
