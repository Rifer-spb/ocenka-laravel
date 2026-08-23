<?php

use App\Manager\Http\Controllers\Phys\InviteController;
use App\Manager\Http\Controllers\Phys\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('phys')->name('phys.')->middleware('auth')->group(function () {
    Route::get('home', fn () => Inertia::render('manager/phys/home'))->name('home');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', fn () => Inertia::render('manager/phys/settings/index'))->name('index');

        Route::prefix('account')->name('account.')->controller(ProfileController::class)->group(function () {
            Route::get('/', 'view')->name('account');
            Route::patch('name', 'updateName')->name('name.update');
            Route::post('phones', 'addPhone')->name('phones.create');
            Route::delete('phones/{phone}', 'deletePhone')->name('phones.delete');
            Route::patch('holiday', 'updateHoliday')->name('holiday.update');
            Route::patch('password', 'changePassword')->name('password.update');
        });

        Route::prefix('legals')->name('legals.')->controller(InviteController::class)->group(function () {
            Route::get('/', 'view')->name('index');
            Route::post('/', 'create')->name('create');
            Route::get('search', 'search')->name('search');
            Route::post('re-send/{id}', 'reSend')->name('reSend');
            Route::post('cancel/{id}', 'cancel')->name('cancel');
            Route::post('confirm/{id}', 'confirm')->name('confirm');
        });
    });
});
