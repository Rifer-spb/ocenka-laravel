<?php

namespace App\Manager\Modules\Phys\Views;

use App\Core\Models\Invite\InviteTab;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Finders\InviteFinder;
use App\Manager\Http\Requests\InviteSearchRequest;
use App\Manager\Modules\Phys\Searchers\InviteSearcher;

class InviteView
{
    public function __construct(
        private InviteFinder $inviteFinder,
        private InviteSearcher $searcher
    ) {}

    public function get(Phys $user, InviteSearchRequest $searchRequest): array
    {
        return [
            'tabs' => InviteTab::all(),
            'counts' => $this->inviteFinder->getCounts($user),
            'invites' => $this->searcher->search($user, $searchRequest),
        ];
    }
}
