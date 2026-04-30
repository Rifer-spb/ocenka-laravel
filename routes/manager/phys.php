<?php

use App\Manager\Modules\Phys\Http\Controllers\ProfileController;
use App\Manager\Modules\Phys\Http\Controllers\legal\InviteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('phys')->name('phys.')->middleware('auth')->group(function () {
    Route::get('home', fn () => Inertia::render('manager/phys/home'))->name('home');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', fn () => Inertia::render('manager/phys/settings/index'))->name('index');

        Route::prefix('account')->name('account.')->controller(ProfileController::class)->group(function () {
            Route::get('/', 'view')->name('account');
            Route::post('name', 'updateName')->name('name.update');
            Route::post('phones', 'addPhone')->name('phones.create');
            Route::delete('phones/{phone}', 'deletePhone')->name('phones.delete');
            Route::put('holiday', 'updateHoliday')->name('holiday.update');
            Route::put('password', 'changePassword')->name('password.update');
        });

        Route::prefix('legals')->name('legals.')->controller(InviteController::class)->group(function () {
            Route::get('/', 'view')->name('index');
            Route::post('/', 'create')->name('create');
            Route::get('search', 'search')->name('search');
            Route::post('re-send/{id}', 'reSend')->name('reSend');
            Route::post('cancel/{id}', 'cancel')->name('cancel');
        });
    });
});
