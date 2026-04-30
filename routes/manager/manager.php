<?php

use App\Manager\AuthController;
use App\Manager\DefaultController;
use App\Manager\Http\Controllers\Legal\InviteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');

Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('home', [DefaultController::class, 'home'])->name('home')->middleware('guest');

    Route::prefix('auth')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('sign-up', 'viewSignUp')->name('viewSignUp')->middleware('guest');
        Route::post('sign-up', 'signUp')->name('signUp')->middleware('guest');
        Route::post('logout', 'logout')->name('logout')->middleware('auth');
        Route::get('sign-in', 'viewSignIn')->name('viewSignIn')->middleware('guest');
        Route::post('sign-in', 'signIn')->name('signIn')->middleware('guest');
    });

    Route::prefix('legals')->name('legals.')->middleware('auth')->group(function () {
        Route::prefix('invites')->name('invites.')->controller(InviteController::class)->group(function () {
            Route::get('tabs', 'tabs')->name('tabs.get');
            Route::get('counts', 'counts')->name('tabs.counts');
        });
    });

    require __DIR__ . '/phys.php';
    require __DIR__ . '/legal.php';
});
