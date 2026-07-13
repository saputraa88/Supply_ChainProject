<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Port;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Hitung jumlah negara yang sedang dipantau oleh user ini
        $totalWatchlist = $user->watchedCountries()->count();
        
        // Hitung total seluruh aset pelabuhan yang terdaftar
        $totalPorts = Port::count();

        return view('dashboard', compact('totalWatchlist', 'totalPorts'));
    }
}