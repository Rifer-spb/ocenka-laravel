<?php

namespace App\Manager\ReadServices\Phys;

use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Phys\Phys;
use App\Manager\Queries\Phys\PhysInviteQuery;

class PhysInviteReadService
{
    public function getCounts(Phys $phys): array
    {
        $counts = [];

        foreach (InviteTab::all() as $tab) {
            $counts[$tab->value] = PhysInviteQuery::searchQuery($phys, $tab)->count();
        }

        return $counts;
    }
}
