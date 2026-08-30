<?php

namespace App\Manager\Providers;

use App\Core\Models\Invite\Events\InviteCreatedEvent;
use App\Manager\Listeners\Invite\SendInviteEmailListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ManagerEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        InviteCreatedEvent::class => [
            SendInviteEmailListener::class
        ],
    ];
}
