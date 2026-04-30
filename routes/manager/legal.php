<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('legal')->name('legal.')->middleware('auth')->group(function () {
    Route::get('home', fn () => Inertia::render('manager/legal/home'))->name('home');
});
