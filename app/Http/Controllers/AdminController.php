<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\Port;

class AdminController extends Controller
{
    /**
     * FITUR KE-10: Admin Control Tower Dashboard
     */
    public function index()
    {
        // 1. Ambil data asli dari database untuk metrik statistik
        $stats = [
            'total_users'     => User::count(),
            'total_countries' => Country::count(),
            'total_ports'     => Port::count(),
            'system_status'   => 'Operational',
        ];

        // 2. Ambil daftar pengguna untuk tabel manajemen user
        $users = User::latest()->paginate(5);

        // 3. Simulasi log sistem AI untuk keperluan demonstrasi sidang
        $systemLogs = [
            [
                'timestamp' => '04:05:12',
                'service'   => 'Weather Live Engine',
                'message'   => 'Sinkronisasi API Open-Meteo berhasil diselesaikan.',
                'type'      => 'Success',
                'color'     => '#10b981'
            ],
            [
                'timestamp' => '02:14:55',
                'service'   => 'Lexicon Geopolitical AI',
                'message'   => 'Pemindaian sentimen berita maritim selesai untuk Region Asia.',
                'type'      => 'Info',
                'color'     => '#3b82f6'
            ],
            [
                'timestamp' => 'Kemarin',
                'service'   => 'Currency Matrix Sync',
                'message'   => 'Kurs valuta asing diperbarui secara hybrid.',
                'type'      => 'Success',
                'color'     => '#10b981'
            ],
        ];

        return view('admin.dashboard', compact('stats', 'users', 'systemLogs'));
    }
}