<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('countries', CountryController::class);
});

require __DIR__.'/auth.php';