<?php

namespace App\Manager\ReadServices\Legal;

use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Legal\Legal;
use App\Manager\Queries\Legal\LegalInviteQuery;

class LegalInviteReadService
{
    public function getCounts(Legal $legal): array
    {
        $counts = [];

        foreach (InviteTab::all() as $tab) {
            $counts[$tab->value] = LegalInviteQuery::searchQuery($legal, $tab)->count();
        }

        return $counts;
    }
}
