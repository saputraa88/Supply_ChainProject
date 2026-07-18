<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController; // Kita pakai ini untuk Index & Show negara
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\PortController; 
use App\Http\Controllers\AdminController; // Tambahan Baru untuk Fitur Ke-10

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ==========================================
    // FITUR KE-4: CURRENCY IMPACT DASHBOARD
    // ==========================================
    Route::get('/currency-impact', [CountryController::class, 'currencyDashboard'])
        ->name('currency.index');

    // ==========================================
    // FITUR KE-7: DATA VISUALIZATION DASHBOARD
    // ==========================================
    Route::get('/historical-dashboard', [CountryController::class, 'historicalDashboard'])
        ->name('historical.index');

    // ==========================================
    // FITUR KE-10: ADMIN CONTROL DASHBOARD
    // ==========================================
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    // ==========================================
    // SEGMEN INTELIJEN NEGARA & RISK SCORING
    // ==========================================
    
    // 1. Daftar semua negara
    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    // 2. SINKRONISASI MASSAL (Harus di atas {country})
    Route::get('/countries/sync-all', [CountryController::class, 'syncAll'])
        ->name('countries.syncAll');

    // 3. FITUR KE-8: PERBANDINGAN NEGARA (Harus di atas {country})
    Route::get('/countries/comparison', [CountryController::class, 'comparison'])
        ->name('countries.comparison');

    // 4. Detail negara (Wildcard ditaruh paling bawah)
    Route::get('/countries/{country}', [CountryController::class, 'show'])
        ->name('countries.show');

    // ==========================================
    // DAFTAR PANTAU (WATCHLIST)
    // ==========================================
    Route::get('/watchlist', [WatchlistController::class, 'index'])
        ->name('watchlist.index');
    
    Route::post('/countries/{country}/watchlist', [WatchlistController::class, 'toggle'])
        ->name('watchlist.toggle');

    // ==========================================
    // CRUD PELABUHAN (PORTS)
    // ==========================================
    Route::get('/ports', [PortController::class, 'index'])->name('ports.index');
    Route::get('/ports/create', [PortController::class, 'create'])->name('ports.create');
    Route::post('/ports', [PortController::class, 'store'])->name('ports.store');
    Route::delete('/ports/{port}', [PortController::class, 'destroy'])->name('ports.destroy');

});

require __DIR__.'/auth.php';