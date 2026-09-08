<?php

namespace App\Core\Finder;

use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InviteFinder
{
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

    public static function getWaitByIdAndPhys(int $id, Phys $phys): Invite
    {
        $model = Invite::where([
            'id' => $id,
            'phys_id' => $phys->id,
            'status' => InviteStatus::WAIT->value,
        ])->first();

        if (! $model) {
            throw new ModelNotFoundException('Отправленная заявка не найдена.');
        }

        return $model;
    }

    public static function getWaitByIdAndLegal(int $id, Legal $legal): Invite
    {
        $model = Invite::where([
            'id' => $id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::WAIT->value,
        ])->first();

        if (! $model) {
            throw new ModelNotFoundException('Отправленная заявка не найдена.');
        }

        return $model;
    }

    public static function getActiveByIdAndLegal(int $id, Legal $legal): Invite
    {
        $model = Invite::where([
            'id' => $id,
            'legal_id' => $legal->id,
            'status' => InviteStatus::ACTIVE->value,
        ])->first();

        if (! $model) {
            throw new ModelNotFoundException('Отправленная заявка не найдена.');
        }

        return $model;
    }
}
