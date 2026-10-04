<?php

use App\Core\Http\Middleware\HandleAppearance;
use App\Core\Http\Middleware\HandleInertiaRequests;
use App\Core\Models\User\Role;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
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
        $exceptions->render(function (\DomainException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => $e->getMessage()], 422);
            }

            return back()->with('error', $e->getMessage());
        });
    })->create();
