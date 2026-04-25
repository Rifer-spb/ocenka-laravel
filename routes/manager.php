<?php

use App\Manager\AuthController;
use App\Manager\DefaultController;
use App\Manager\Modules\Phys\Http\Controllers\ProfileController;
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

            Route::prefix('account')->name('account.')->group(function () {
                Route::get('/', [ProfileController::class, 'view'])->name('account');
                Route::post('name', [ProfileController::class, 'updateName'])->name('name.update');
                Route::post('phones', [ProfileController::class, 'addPhone'])->name('phones.create');
                Route::delete('phones/{phone}', [ProfileController::class, 'deletePhone'])->name('phones.delete');
                Route::put('holiday', [ProfileController::class, 'updateHoliday'])->name('holiday.update');
                Route::put('password', [ProfileController::class, 'changePassword'])->name('password.update');
            });
        });
    });

    Route::prefix('legal')->name('legal.')->middleware('auth')->group(function () {
        Route::get('home', fn () => Inertia::render('manager/legal/home'))->name('home');
    });
});
