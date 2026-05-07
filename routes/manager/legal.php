<?php

use App\Manager\Modules\Legal\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('legal')->name('legal.')->middleware('auth')->group(function () {
    Route::get('home', fn () => Inertia::render('manager/legal/home'))->name('home');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', fn () => Inertia::render('manager/legal/settings/index'))->name('index');

        Route::prefix('account')->name('account.')->controller(ProfileController::class)->group(function () {
            Route::get('/', 'view')->name('account');
            Route::put('company', 'updateCompany')->name('company.update');
            Route::put('password', 'changePassword')->name('password.update');
        });
    });
});
