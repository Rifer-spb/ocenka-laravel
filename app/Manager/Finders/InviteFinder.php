<?php

namespace App\Manager\Finders;

use App\Core\Models\Invite\ForWho;
use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\User;
use App\Manager\Helpers\InviteHelper;

class InviteFinder
{
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
                $andWhere['for'] = $user->isPhys() ? ForWho::PHYS->value : ForWho::LEGAL->value;
            } elseif ($tab->isOutbox()) {
                $andWhere['for'] = $user->isPhys() ? ForWho::LEGAL->value : ForWho::PHYS->value;
            }

            $query = clone $baseQuery;
            $counts[$tab->value] = $query->where($andWhere)->count();
        }

        return $counts;
    }
}
