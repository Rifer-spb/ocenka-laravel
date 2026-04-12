<?php

use App\Http\Controllers\DefaultController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');

Route::get('/auth', function () {
    Route::get('/auth/sign-up', [AuthController::class, 'index'])->name('auth.sign-up');

    //return Inertia::render('home', [
    //    'canRegister' => Features::enabled(Features::registration()),
    //]);
})->name('default');
