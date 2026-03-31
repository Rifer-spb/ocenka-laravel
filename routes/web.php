<?php

use App\Http\Controllers\DefaultController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [DefaultController::class, 'home'])->name('default.home');
Route::get('/auth/sign-up', [AuthController::class, 'index'])->name('auth.sign-up');

/*
Route::get('/', function () {
    Route::get('default/home', [DefaultController::class, 'home'])->name('default.home');

    //return Inertia::render('home', [
    //    'canRegister' => Features::enabled(Features::registration()),
    //]);
})->name('default');
*/

// require __DIR__.'/settings.php';
