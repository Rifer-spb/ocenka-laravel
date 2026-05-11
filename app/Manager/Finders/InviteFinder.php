<?php

namespace App\Manager\Finders;

use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\User;

class InviteFinder
{
    public function getCounts(User $user): array
    {
        $tabs = InviteTab::all();

        $userWhere = $user->isPhys()
            ? ['phys_id' => $user->id]
            : ['legal_id' => $user->id];

        $baseQuery = Invite::where($userWhere);

        $counts = [];
        foreach ($tabs as $tab) {
            $andWhere = ['status' => $tab->getStatus()];

            if ($tab->isInbox()) {
                $andWhere['for'] = $user->isPhys() ? Invite::FOR_PHYS : Invite::FOR_LEGAL;
            } elseif ($tab->isOutbox()) {
                $andWhere['for'] = $user->isPhys() ? Invite::FOR_LEGAL : Invite::FOR_PHYS;
            }

            $query = clone $baseQuery;
            $counts[$tab->id] = $query->where($andWhere)->count();
        }

        return $counts;
    }
}
