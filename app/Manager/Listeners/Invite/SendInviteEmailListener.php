<?php

namespace App\Manager\Listeners\Invite;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\Invite\Events\InviteCreatedEvent;
use App\Manager\Mails\Invite\SendInviteMail;

class SendInviteEmailListener
{
    /**
     * @throws \Exception
     */
    public function handle(InviteCreatedEvent $event): void
    {
        $invite = $event->invite;
        $user = $invite->getForUser();

        SendMailJob::dispatch(SendInviteMail::create($user));
    }
}
