<?php

namespace App\Manager\Finders;

use App\Core\Models\Legal\LegalEmployee;
use App\Core\Models\Legal\LegalInviteTab;
use App\Core\Models\User\User;

class InviteFinder
{
    public function getCounts(User $user): array
    {
        $tabs = LegalInviteTab::all();

        $userWhere = $user->isPhys()
            ? ['phys_id' => $user->id]
            : ['legal_id' => $user->id];

        $baseQuery = LegalEmployee::where($userWhere);

        $counts = [];
        foreach ($tabs as $tab) {
            $andWhere = ['status' => $tab->getStatus()];

            if ($tab->isInbox()) {
                $andWhere['for'] = $user->isPhys() ? LegalEmployee::FOR_PHYS : LegalEmployee::FOR_LEGAL;
            } elseif ($tab->isOutbox()) {
                $andWhere['for'] = $user->isPhys() ? LegalEmployee::FOR_LEGAL : LegalEmployee::FOR_PHYS;
            }

            $query = clone $baseQuery;
            $counts[$tab->id] = $query->where($andWhere)->count();
        }

        return $counts;
    }
}
