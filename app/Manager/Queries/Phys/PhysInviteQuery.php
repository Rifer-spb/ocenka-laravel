<?php

namespace App\Manager\Queries\Phys;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Phys\Phys;
use App\Manager\Helpers\InviteHelper;
use Illuminate\Database\Eloquent\Builder;

class PhysInviteQuery
{
    public static function searchQuery(Phys $phys, InviteTab $tab): Builder
    {
        $query = Invite::where('phys_id', $phys->id)
            ->with(['legal.profile'])
            ->where('status', InviteHelper::getStatusByTab($tab)->value);

        if ($tab->isInbox()) {
            $query->where('for', InviteForWho::PHYS);
        } elseif ($tab->isOutbox()) {
            $query->where('for', InviteForWho::LEGAL);
        }

        return $query;
    }
}
