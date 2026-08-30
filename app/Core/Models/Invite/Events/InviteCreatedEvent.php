<?php

namespace App\Core\Models\Invite\Events;

use App\Core\Models\Invite\Invite;
use Illuminate\Foundation\Events\Dispatchable;

class InviteCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public Invite $invite
    ) {}
}
