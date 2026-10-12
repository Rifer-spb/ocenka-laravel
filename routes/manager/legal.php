<?php

use App\Manager\Http\Controllers\Legal\CallCommentTemplateController;
use App\Manager\Http\Controllers\Legal\EmployeeController;
use App\Manager\Http\Controllers\Legal\InviteController;
use App\Manager\Http\Controllers\Legal\ProfileController;
use App\Manager\Http\PageControllers\Legal\HomePageController;
use App\Manager\Http\PageControllers\Legal\Settings\AccountPageController;
use App\Manager\Http\PageControllers\Legal\Settings\CallPageController;
use App\Manager\Http\PageControllers\Legal\Settings\InvitePageController;
use App\Manager\Http\PageControllers\Legal\Settings\RegistryPageController;
use App\Manager\Http\PageControllers\Legal\Settings\SettingsPageController;
use Illuminate\Support\Facades\Route;

Route::prefix('legal')->name('legal.')->middleware('auth')->group(function () {
    //PageControllers
    Route::get('home', HomePageController::class)->name('home');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', SettingsPageController::class)->name('index');
        Route::get('account', AccountPageController::class)->name('account');
        Route::get('invites', InvitePageController::class)->name('invites');
        Route::get('registry', RegistryPageController::class)->name('registry');
        Route::get('call', CallPageController::class)->name('call');
    });

    //Controllers
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::patch('company', 'updateCompany')->name('company.update');
        Route::patch('password', 'changePassword')->name('password.update');
        Route::patch('registry-template', 'updateRegistryTemplate')->name('updateRegistryTemplate');
    });

    Route::prefix('invites')->name('invites.')->controller(InviteController::class)->group(function () {
        Route::post('/', 'create')->name('create');

        Route::prefix('{invite}')->group(function () {
            Route::post('re-send', 'reSend')->name('reSend');
            Route::patch('cancel', 'cancel')->name('cancel');
            Route::patch('confirm', 'confirm')->name('confirm');
            Route::patch('close', 'close')->name('close');
        });
    });

    Route::prefix('employees')->name('employees.')->controller(EmployeeController::class)->group(function () {
        Route::prefix('{employee}')->group(function () {
            Route::patch('do-report/{accessId}', 'updateDoReport')->name('updateDoReport');
            Route::patch('write-report/{accessId}', 'updateWriteReport')->name('updateWriteReport');
            Route::patch('ride', 'updateRide')->name('updateRide');
            Route::patch('manager', 'updateManager')->name('updateManager');
            Route::patch('work-rate', 'updateWorkRate')->name('updateWorkRate');
            Route::patch('call', 'updateCall')->name('updateCall');
            Route::patch('registry', 'updateRegistry')->name('updateRegistry');
        });
    });

    Route::prefix('call-templates')
        ->name('callTemplates.')
        ->controller(CallCommentTemplateController::class)
        ->group(function () {
            Route::post('/', 'create')->name('create');
            Route::patch('{template}', 'update')->name('update');
            Route::delete('{template}', 'delete')->name('delete');
        }
    );
});
