<?php

use App\Http\Controllers\Manager\AuthController;
use App\Http\Controllers\Manager\DefaultController;
use App\Http\Controllers\Manager\Phys\Settings\AccountController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');

Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('home', [DefaultController::class, 'home'])->name('home')->middleware('guest');

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('sign-up', [AuthController::class, 'viewSignUp'])->name('viewSignUp')->middleware('guest');
        Route::post('sign-up', [AuthController::class, 'signUp'])->name('signUp')->middleware('guest');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
        Route::get('sign-in', [AuthController::class, 'viewSignIn'])->name('viewSignIn')->middleware('guest');
        Route::post('sign-in', [AuthController::class, 'signIn'])->name('signIn')->middleware('guest');
    });

    Route::prefix('phys')->name('phys.')->middleware('auth')->group(function () {
        Route::get('home', fn () => Inertia::render('manager/phys/home'))->name('home');

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', fn () => Inertia::render('manager/phys/settings/index'))->name('index');
            Route::get('account', [AccountController::class, 'view'])->name('account');
            Route::post('account/name', [AccountController::class, 'updateName'])->name('updateName');
            Route::post('account/phones', [AccountController::class, 'addPhone'])->name('addPhone');
            Route::delete('account/phones/{phone}', [AccountController::class, 'deletePhone'])->name('deletePhone');
        });
    });
});
