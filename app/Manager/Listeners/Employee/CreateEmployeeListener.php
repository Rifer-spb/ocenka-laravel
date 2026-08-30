<?php

namespace App\Manager\Listeners\Employee;

use App\Core\Models\Employee\Employee;
use App\Core\Models\Invite\Events\InviteConfirmedEvent;

class CreateEmployeeListener
{
    public function handle(InviteConfirmedEvent $event): void
    {
        $invite = $event->invite;

        Employee::createNew($invite);
    }
}
