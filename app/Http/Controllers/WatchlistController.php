<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    /**
     * Menampilkan daftar negara yang sedang dipantau oleh user log in.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Mengambil semua negara yang ditandai oleh user ini
        $watchedCountries = $user->watchedCountries()->get();

        return view('watchlist.index', compact('watchedCountries'));
    }

    /**
     * Menambah atau Menghapus (Toggle) negara dari daftar pantau.
     */
    public function toggle(Country $country)
    {
        $user = Auth::user();

        // toggle() otomatis menambah jika belum ada, dan menghapus jika sudah ada di tabel watchlist
        $user->watchedCountries()->toggle($country->id);

        // Bersihkan relasi di memori agar state langsung ter-update di view
        $user->unsetRelation('watchedCountries');

        return redirect()->back()->with('success', 'Status daftar pantau negara berhasil diperbarui.');
    }
}