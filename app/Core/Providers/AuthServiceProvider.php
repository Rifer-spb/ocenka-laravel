<?php

namespace App\Core\Providers;

use App\Core\Entities\User\Client\Client;
use App\Core\Entities\User\Legal\Legal;
use App\Core\Entities\User\Notary\NotaryUser;
use App\Core\Entities\User\Phys\Phys;
use App\Core\Entities\User\Role;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Auth::provider('eloquent', function ($app, $config) {
            return new class($app['hash'], $config['model']) extends EloquentUserProvider
            {
                public function retrieveById($identifier)
                {
                    $user = parent::retrieveById($identifier);

                    if (! $user) {
                        return null;
                    }

                    return match ($user->role) {
                        Role::PHYS->value => Phys::find($identifier),
                        Role::LEGAL->value => Legal::find($identifier),
                        Role::CLIENT->value => Client::find($identifier),
                        Role::NOTARY->value => NotaryUser::find($identifier),
                        default => $user,
                    };
                }
            };
        });
    }
}
