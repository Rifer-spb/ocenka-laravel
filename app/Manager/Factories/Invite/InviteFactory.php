<?php

namespace App\Manager\Factories\Invite;

use App\Core\Finder\InviteFinder;
use App\Core\Models\Invite\ForWho;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;

class InviteFactory
{
    public function create(Phys $phys, Legal $legal, ForWho $for): Invite
    {
        if (InviteFinder::hasWait($phys, $legal)) {
            throw new \DomainException('Заявка с указанным уже существует.');
        }

        if (InviteFinder::hasActive($phys, $legal)) {
            throw new \DomainException('Связь с указанным уже установлена.');
        }

        return Invite::create([
            'phys_id' => $phys->id,
            'legal_id' => $legal->id,
            'for' => $for->value,
            'status' => InviteStatus::WAIT->value,
        ]);
    }
}
