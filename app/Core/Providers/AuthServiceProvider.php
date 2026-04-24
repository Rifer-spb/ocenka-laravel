<?php

namespace App\Core\Providers;

use App\Core\Models\User\Client\Client;
use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Notary\Notary;
use App\Core\Models\User\Phys\Phys;
use App\Core\Models\User\Role;
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
                        Role::NOTARY->value => Notary::find($identifier),
                        default => $user,
                    };
                }
            };
        });
    }
}
