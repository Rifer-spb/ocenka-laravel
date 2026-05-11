<?php

use App\Manager\Modules\Legal\Http\Controllers\ProfileController;
use App\Manager\Modules\Legal\Http\Controllers\InviteController;
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

        Route::prefix('persons')->name('persons.')->controller(InviteController::class)->group(function () {
            Route::get('/', 'view')->name('index');
            Route::post('/', 'create')->name('create');
            Route::get('search', 'search')->name('search');
            Route::post('re-send/{id}', 'reSend')->name('reSend');
            Route::post('cancel/{id}', 'cancel')->name('cancel');
            Route::post('confirm/{id}', 'confirm')->name('confirm');
            Route::post('complete/{id}', 'complete')->name('complete');
        });
    });
});
