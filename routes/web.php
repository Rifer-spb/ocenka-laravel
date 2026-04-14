<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\AuthController;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');

Route::prefix('auth')->group(function () {
    Route::get('sign-up', [AuthController::class, 'index'])->name('auth.sign-up.index');
    Route::post('sign-up', [AuthController::class, 'store'])->name('auth.sign-up.store');
});
