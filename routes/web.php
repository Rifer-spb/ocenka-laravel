<?php

use App\Http\Controllers\DefaultController;
use App\Http\Controllers\Manager\AuthController;
use App\Http\Controllers\Manager\Phys\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');

Route::prefix('manager')->name('manager.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('sign-up', [AuthController::class, 'viewSignUp'])->name('viewSignUp');
        Route::post('sign-up', [AuthController::class, 'signUp'])->name('signUp');
    });

    Route::middleware('auth')->group(function () {
        Route::prefix('phys')->name('phys.')->group(function () {
            Route::get('home', [HomeController::class, 'index'])->name('index');
        });
    });
});
