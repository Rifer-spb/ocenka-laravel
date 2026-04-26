<?php

namespace App\Manager\Modules\Phys\Readers\Legal;

use App\Core\Models\Legal\LegalEmployee;
use App\Core\Models\User\Phys\Phys;
use App\Manager\Modules\Phys\Http\Requests\Legal\Invite\SearchRequest;

class InviteSearcher
{
    public static function search(Phys $user, SearchRequest $request): array
    {
        $allRequests = LegalEmployee::where('phys_id', $user->id);

        match ($request->type) {
            'inbox' => $allRequests->where([
                'for' => LegalEmployee::FOR_PHYS,
                'status' => LegalEmployee::STATUS_WAIT,
            ]),
            'outbox' => $allRequests->where([
                'for' => LegalEmployee::FOR_LEGAL,
                'status' => LegalEmployee::STATUS_WAIT,
            ]),
            'active' => $allRequests->where([
                'status' => LegalEmployee::STATUS_ACTIVE,
            ]),
            'fired' => $allRequests->where([
                'status' => LegalEmployee::STATUS_FIRED,
            ]),
        };

        return $allRequests->get()->toArray();
    }
}
