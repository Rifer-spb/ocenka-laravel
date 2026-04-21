<?php

use App\Http\Controllers\Manager\AuthController;
use App\Http\Controllers\Manager\DefaultController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manager\Phys\HomeController;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');

Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('home', [DefaultController::class, 'home'])->name('home')->middleware('guest');

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('sign-up', [AuthController::class, 'viewSignUp'])->name('viewSignUp')->middleware('guest');
        Route::post('sign-up', [AuthController::class, 'signUp'])->name('signUp')->middleware('guest');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
        Route::get('sign-in', [AuthController::class, 'viewSignIn'])->name('viewSignIn')->middleware('guest');
        Route::post('sign-in', [AuthController::class, 'signIn'])->name('signIn')->middleware('guest');
    });

    Route::prefix('phys')->name('phys.')->middleware('auth')->group(function () {
        Route::get('home', [HomeController::class, 'index'])->name('home');
    });
});
