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
        
        // 1. Mengambil semua negara yang ditandai oleh user ini
        $watchedCountries = $user->watchedCountries()->get();

        // 2. Kamus Lokal Cadangan (Sama seperti di CountryController agar sinkron)
        $localBackup = [
            'af' => 'Asia',
            'id' => 'Asia',
            'us' => 'Americas',
            'cn' => 'Asia',
            'de' => 'Europe',
            'au' => 'Oceania',
            'sg' => 'Asia',
            'my' => 'Asia',
            'jp' => 'Asia',
        ];

        // 3. Intersepsi Data: Jika region berisi '-' atau kosong, isi dengan Kamus Lokal
        foreach ($watchedCountries as $item) {
            $countryCode = trim(strtolower($item->code));
            
            if (!$item->region || $item->region == '-') {
                $item->region = $localBackup[$countryCode] ?? 'Global Zone';
            }
        }

        // 4. Kirim data yang sudah bersih ke view premium kamu
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