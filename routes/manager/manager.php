<?php

use App\Manager\Http\PageControllers\AuthPageController;
use App\Manager\Http\PageControllers\IndexPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexPageController::class)->name('default.home');

Route::name('manager.')->group(function () {
    Route::get('home', IndexPageController::class)->name('home')->middleware('guest');

    Route::prefix('auth')->name('auth.')->controller(AuthPageController::class)->group(function () {
        Route::get('sign-up', 'viewSignUp')->name('viewSignUp')->middleware('guest');
        Route::post('sign-up', 'signUp')->name('signUp')->middleware('guest');
        Route::post('logout', 'logout')->name('logout')->middleware('auth');
        Route::get('sign-in', 'viewSignIn')->name('viewSignIn')->middleware('guest');
        Route::post('sign-in', 'signIn')->name('signIn')->middleware('guest');
    });

    require __DIR__ . '/phys.php';
    require __DIR__ . '/legal.php';
});
