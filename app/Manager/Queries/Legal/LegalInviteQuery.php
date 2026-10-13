<?php

namespace App\Manager\Queries\Legal;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Legal\Legal;
use App\Manager\Helpers\InviteHelper;
use Illuminate\Database\Eloquent\Builder;

class LegalInviteQuery
{
    public static function searchQuery(Legal $legal, InviteTab $tab): Builder
    {
        $query = Invite::where('legal_id', $legal->id)
            ->with([
                'phys.profile',
                'phys.employee.reportAccess.direction',
            ])
            ->where('status', InviteHelper::getStatusByTab($tab)->value);

        if ($tab->isInbox()) {
            $query->where('for', InviteForWho::LEGAL);
        } elseif ($tab->isOutbox()) {
            $query->where('for', InviteForWho::PHYS);
        }

        return $query;
    }
}
