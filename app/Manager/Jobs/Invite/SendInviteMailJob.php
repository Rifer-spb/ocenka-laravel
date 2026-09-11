<?php

namespace App\Manager\Jobs\Invite;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\Invite\Invite;
use App\Manager\Mails\Invite\SendInviteMail;

class SendInviteMailJob
{
    public static function dispatch(Invite $invite): void
    {
        $mail = SendInviteMail::create($invite->getForWhoUser());
        SendMailJob::dispatch($mail);
    }
}
