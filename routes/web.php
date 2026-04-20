<?php

use App\Http\Controllers\Manager\AuthController;
use App\Http\Controllers\Manager\DefaultController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');

Route::prefix('manager')->name('manager.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('sign-up', [AuthController::class, 'viewSignUp'])->name('viewSignUp');
        Route::post('sign-up', [AuthController::class, 'signUp'])->name('signUp');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('sign-in', [AuthController::class, 'viewSignIn'])->name('viewSignIn');
        Route::post('sign-in', [AuthController::class, 'signIn'])->name('signIn');
    });

    Route::get('home', [DefaultController::class, 'home'])->name('home');
});
