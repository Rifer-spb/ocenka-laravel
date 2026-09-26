<?php

use App\Manager\Http\Controllers\Legal\InviteController;
use App\Manager\Http\Controllers\Legal\ProfileController;
use App\Manager\Http\Controllers\Legal\RegistryController;
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

            Route::prefix('{invite}')->group(function () {
                Route::post('re-send', 'reSend')->name('reSend');
                Route::patch('cancel', 'cancel')->name('cancel');
                Route::patch('confirm', 'confirm')->name('confirm');
                Route::patch('close', 'close')->name('close');
                Route::patch('do-report/{accessId}', 'updateDoReport')->name('updateDoReport');
                Route::patch('write-report/{accessId}', 'updateWriteReport')->name('updateWriteReport');
                Route::patch('ride', 'updateRide')->name('updateRide');
                Route::patch('manager', 'updateManager')->name('updateManager');
                Route::patch('work-rate', 'updateWorkRate')->name('updateWorkRate');
            });
        });

        Route::prefix('registry')->name('registry.')->controller(RegistryController::class)->group(function () {
            Route::get('/', 'view')->name('index');
            Route::patch('template', 'updateTemplate')->name('updateTemplate');
            Route::patch('access/{employee}', 'updateAccess')->name('updateAccess');
        });
    });
});
