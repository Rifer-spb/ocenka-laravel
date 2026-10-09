<?php

use App\Manager\Http\Controllers\Phys\InviteController;
use App\Manager\Http\Controllers\Phys\NotaryController;
use App\Manager\Http\Controllers\Phys\ProfileController;
use App\Manager\Http\PageControllers\Phys\HomePageController;
use App\Manager\Http\PageControllers\Phys\Notaries\NotariesExportPageController;
use App\Manager\Http\PageControllers\Phys\Notaries\NotariesExportRegionPageController;
use App\Manager\Http\PageControllers\Phys\Notaries\NotariesPageController;
use App\Manager\Http\PageControllers\Phys\Settings\AccountPageController;
use App\Manager\Http\PageControllers\Phys\Settings\InvitePageController;
use App\Manager\Http\PageControllers\Phys\Settings\SettingsPageController;
use Illuminate\Support\Facades\Route;

Route::prefix('phys')->name('phys.')->middleware('auth')->group(function () {
    //PageControllers
    Route::get('home', HomePageController::class)->name('home');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', SettingsPageController::class)->name('index');
        Route::get('account', AccountPageController::class)->name('account');
        Route::get('invites', InvitePageController::class)->name('invites');
    });

    Route::get('notaries', NotariesPageController::class)->name('notaries');
    Route::get('notaries/export', NotariesExportPageController::class)->name('notariesExport');
    Route::get('notaries/region-export', NotariesExportRegionPageController::class)->name('notariesRegionExport');

    //Controllers
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::patch('name', 'updateName')->name('name.update');
        Route::post('phones', 'addPhone')->name('phones.create');
        Route::delete('phones/{phone}', 'deletePhone')->name('phones.delete');
        Route::patch('holiday', 'updateHoliday')->name('holiday.update');
        Route::patch('password', 'changePassword')->name('password.update');
    });

    Route::prefix('invites')->name('invites.')->controller(InviteController::class)->group(function () {
        Route::post('/', 'create')->name('create');

        Route::prefix('{invite}')->group(function () {
            Route::post('re-send', 'reSend')->name('reSend');
            Route::patch('cancel', 'cancel')->name('cancel');
            Route::patch('confirm', 'confirm')->name('confirm');
        });
    });

    Route::prefix('notaries')->name('notaries.')->controller(NotaryController::class)->group(function () {
        Route::get('export-search', 'exportSearch')->name('exportSearch');
        Route::get('{notary}', 'getNotary')->name('getNotary');
        Route::patch('{notary}', 'updateNotary')->name('updateNotary');
    });
});
