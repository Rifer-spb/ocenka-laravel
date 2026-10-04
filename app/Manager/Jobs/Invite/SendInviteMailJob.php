<?php

namespace App\Manager\Jobs\Invite;

use App\Core\Jobs\SendMailJob;
use App\Core\Mails\Invite\SendInviteMail;
use App\Core\Models\Invite\Invite;

class SendInviteMailJob
{
    public static function dispatch(Invite $invite): void
    {
        $mail = SendInviteMail::create($invite->getForWhoUser());
        SendMailJob::dispatch($mail);
    }
}
