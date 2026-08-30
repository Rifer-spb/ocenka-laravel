<?php

namespace App\Manager\Jobs\Invite;

use App\Core\Jobs\SendMailJob;
use App\Core\Models\Invite\Invite;
use App\Manager\Mails\Invite\SendInviteMail;

class SendInviteMailJob extends SendMailJob
{
    /**
     * @param Invite $invite
     * @throws \Exception
     */
    public function __construct(Invite $invite)
    {
        $mail = SendInviteMail::create($invite->getForUser());

        parent::__construct($mail);
    }
}
