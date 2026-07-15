<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController; // Import ApiController kita 🔥

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rute Bawaan Laravel Sanctum (Biarkan tetap ada)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// RUTE REST API GLOBAL SUPPLY CHAIN (Sesuai Halaman 9 Dokumen PDF Dosen) 🚀
Route::get('/countries', [ApiController::class, 'getCountries']);
Route::get('/risk', [ApiController::class, 'getRisk']);

// Tambahkan ini di bawah rute countries dan risk kamu yang sudah ada:
Route::get('/ports', [ApiController::class, 'getPorts']);
Route::get('/news', [ApiController::class, 'getNews']);