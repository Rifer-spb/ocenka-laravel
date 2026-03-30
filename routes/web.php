<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DefaultController;

Route::get('/', [DefaultController::class, 'home'])
    ->name('default.home');

/*
Route::get('/', function () {
    Route::get('default/home', [DefaultController::class, 'home'])->name('default.home');

    //return Inertia::render('home', [
    //    'canRegister' => Features::enabled(Features::registration()),
    //]);
})->name('default');
*/

Route::get('dashboard', function () {
    return Inertia::render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
