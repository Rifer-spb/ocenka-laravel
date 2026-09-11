<?php

namespace App\Manager\Finders;

use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\Invite\InviteStatus;
use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\User;
use App\Exceptions\EntityNotFoundException;
use App\Manager\Helpers\InviteHelper;

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
            throw new EntityNotFoundException('Отправленная заявка не найдена.');
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
            throw new EntityNotFoundException('Отправленная заявка не найдена.');
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
            throw new EntityNotFoundException('Отправленная заявка не найдена.');
        }

        return $model;
    }

    public static function getCounts(User $user): array
    {
        $tabs = InviteTab::all();

        $userWhere = $user->isPhys()
            ? ['phys_id' => $user->id]
            : ['legal_id' => $user->id];

        $baseQuery = Invite::where($userWhere);

        $counts = [];
        foreach ($tabs as $tab) {
            $andWhere = ['status' => InviteHelper::getStatusByTab($tab)];

            if ($tab->isInbox()) {
                $andWhere['for'] = $user->isPhys() ? InviteForWho::PHYS->value : InviteForWho::LEGAL->value;
            } elseif ($tab->isOutbox()) {
                $andWhere['for'] = $user->isPhys() ? InviteForWho::LEGAL->value : InviteForWho::PHYS->value;
            }

            $query = clone $baseQuery;
            $counts[$tab->value] = $query->where($andWhere)->count();
        }

        return $counts;
    }
}
