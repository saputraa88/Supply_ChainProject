<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController; // Mengimpor ApiController 🔥

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rute Bawaan Laravel Sanctum (Biarkan tetap ada)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// RUTE REST API GLOBAL SUPPLY CHAIN (Wajib Sesuai Dokumen PDF Halaman 9) 🚀
Route::get('/countries', [ApiController::class, 'getCountries']);
Route::get('/risk', [ApiController::class, 'getRisk']);
Route::get('/ports', [ApiController::class, 'getPorts']);
Route::get('/news', [ApiController::class, 'getNews']);
Route::get('/currency', [ApiController::class, 'getCurrency']); // Ditambahkan agar lulus spesifikasi tugas!