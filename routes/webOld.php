<?php

use App\Http\Controllers\Manager\AuthController;
use App\Http\Controllers\Manager\DefaultController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');

Route::get('/auth', function () {
    Route::get('/auth/sign-up', [AuthController::class, 'index'])->name('auth.sign-up');

    //return Inertia::render('home', [
    //    'canRegister' => Features::enabled(Features::registration()),
    //]);
})->name('default');
