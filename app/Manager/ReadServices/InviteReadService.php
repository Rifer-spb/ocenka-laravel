<?php

namespace App\Manager\ReadServices;

use App\Core\Models\Invite\Invite;
use App\Core\Models\Invite\InviteForWho;
use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\User;
use App\Manager\Helpers\InviteHelper;
use Illuminate\Database\Eloquent\Builder;

class InviteReadService
{
    public static function getCounts(User $user): array
    {
        $counts = [];

        foreach (InviteTab::all() as $tab) {
            $counts[$tab->value] = self::querySearch($user, $tab)->count();
        }

        return $counts;
    }

    public static function querySearch(User $user, InviteTab $tab): Builder
    {
        $mine = $user->isPhys() ? InviteForWho::PHYS : InviteForWho::LEGAL;
        $theirs = $user->isPhys() ? InviteForWho::LEGAL : InviteForWho::PHYS;

        $query = Invite::where($user->isPhys() ? 'phys_id' : 'legal_id', $user->id)
            ->where('status', InviteHelper::getStatusByTab($tab)->value);

        if ($tab->isInbox()) {
            $query->where('for', $mine->value);
        } elseif ($tab->isOutbox()) {
            $query->where('for', $theirs->value);
        }

        return $query;
    }
}
