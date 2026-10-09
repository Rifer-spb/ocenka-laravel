<?php

namespace App\Core\Finders;

use App\Core\Entities\EntityNotFoundException;
use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteStatus;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Phys\Phys;

class InviteFinder
{
    public static function getById(int $id): Invite
    {
        $employee = Invite::find($id);

        if (! $employee) {
            throw new EntityNotFoundException('Приглашение не найдено.');
        }

        return $employee;
    }

    public static function hasWait(Phys $phys, Legal $legal): bool
    {
        return Invite::where('phys_id', $phys->id)
            ->where('legal_id', $legal->id)
            ->where('status', InviteStatus::WAIT->value)
            ->exists();
    }

    public static function hasActive(Phys $phys, Legal $legal): bool
    {
        return Invite::where('phys_id', $phys->id)
            ->where('legal_id', $legal->id)
            ->where('status', InviteStatus::ACTIVE->value)
            ->exists();
    }
}
