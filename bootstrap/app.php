<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use App\Models\User\Role;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/manager.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->redirectGuestsTo('/manager/auth/sign-in');

        $middleware->redirectUsersTo(function (Request $request) {
            return match ($request->user()->role) {
                Role::PHYS->value => '/manager/phys/home',
                Role::LEGAL->value => 'manager/legal/home',
                Role::CLIENT->value => '/client/home',
                Role::NOTARY->value => '/notary/home'
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
