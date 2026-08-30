<?php

namespace App\Core\Models\Invite\Events;

use App\Core\Models\Invite\Invite;
use Illuminate\Foundation\Events\Dispatchable;

class InviteConfirmedEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Invite $invite
    ) {}
}
