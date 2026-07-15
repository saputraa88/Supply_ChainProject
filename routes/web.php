<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController; // Kita pakai ini untuk Index & Show negara
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\PortController; 

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Daftar semua negara
    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    // ==========================================
    // SINKRONISASI MASSAL (Taruh Di Atas Detail `{country}`)
    // ==========================================
    Route::get('/countries/sync-all', [CountryController::class, 'syncAll'])
        ->name('countries.syncAll');

    // Detail negara
    Route::get('/countries/{country}', [CountryController::class, 'show'])
        ->name('countries.show');

    // Watchlist
    Route::get('/watchlist', [WatchlistController::class, 'index'])
        ->name('watchlist.index');
    
    Route::post('/countries/{country}/watchlist', [WatchlistController::class, 'toggle'])
        ->name('watchlist.toggle');

    // ==========================================
    // BAGIAN BARU: CRUD PELABUHAN (PORTS)
    // ==========================================
    Route::get('/ports', [PortController::class, 'index'])->name('ports.index');
    Route::get('/ports/create', [PortController::class, 'create'])->name('ports.create');
    Route::post('/ports', [PortController::class, 'store'])->name('ports.store');
    Route::delete('/ports/{port}', [PortController::class, 'destroy'])->name('ports.destroy');

});

require __DIR__.'/auth.php';