<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryListController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Daftar semua negara
    Route::get('/countries', [CountryListController::class, 'index'])
        ->name('countries.index');

    // Detail negara
    Route::get('/countries/{country}', [CountryListController::class, 'show'])
        ->name('countries.show');

});

require __DIR__.'/auth.php';