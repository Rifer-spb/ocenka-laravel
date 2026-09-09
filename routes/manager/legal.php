<?php

use App\Manager\Http\Controllers\Legal\InviteController;
use App\Manager\Http\Controllers\Legal\ProfileController;
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

        Route::prefix('invites')->name('invites.')->controller(InviteController::class)->group(function () {
            Route::get('/', 'view')->name('index');
            Route::post('/', 'create')->name('create');
            Route::get('search', 'search')->name('search');

            Route::prefix('{invite}')->group(function () {
                Route::post('re-send', 'reSend')->name('reSend');
                Route::patch('cancel', 'cancel')->name('cancel');
                Route::patch('confirm', 'confirm')->name('confirm');
                Route::patch('complete', 'complete')->name('complete');
                Route::patch('do-report/{accessId}', 'updateDoReport')->name('updateDoReport');
                Route::patch('write-report/{accessId}', 'updateWriteReport')->name('updateWriteReport');
            });
        });
    });
});
