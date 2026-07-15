<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\Country;
use Illuminate\Http\Request;

class PortController extends Controller
{
    /**
     * Menampilkan daftar semua pelabuhan & Dashboard Peta
     */
    public function index()
    {
        // Mengambil semua data pelabuhan beserta data negara relasinya
        $ports = Port::with('country')->get();

        // Mengambil daftar negara agar bisa dipilih pada dropdown form registrasi
        $countries = Country::orderBy('name', 'asc')->get();

        // Mengarahkan ke file resources/views/ports/index.blade.php dengan membawa data ports & countries
        return view('ports.index', compact('ports', 'countries'));
    }

    /**
     * Menampilkan form registrasi pelabuhan baru (opsional jika tidak pakai modal)
     */
    public function create()
    {
        $countries = Country::orderBy('name', 'asc')->get();
        return view('ports.create', compact('countries'));
    }

    /**
     * Menyimpan data pelabuhan baru ke database beserta koordinat peta
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:ports,code',
            'country_id' => 'required|exists:countries,id',
            'latitude' => 'required|numeric',   // Wajib diisi untuk menentukan titik di Peta Leaflet
            'longitude' => 'required|numeric',  // Wajib diisi untuk menentukan titik di Peta Leaflet
        ]);

        Port::create($request->all());

        return redirect()->route('ports.index')->with('success', 'Infrastruktur pelabuhan berhasil didaftarkan!');
    }

    /**
     * Menghapus data pelabuhan
     */
    public function destroy(Port $port)
    {
        $port->delete();

        return redirect()->route('ports.index')->with('success', 'Infrastruktur pelabuhan berhasil dihapus.');
    }

    /**
     * REST API Endpoint: GET /api/ports
     * Memenuhi spesifikasi wajib proyek dan digunakan untuk memetakan lokasi secara interaktif menggunakan AJAX
     */
    public function apiIndex(Request $request)
    {
        $search = $request->query('search');
        $countryId = $request->query('country_id');

        // Mengambil data pelabuhan berdasarkan filter pencarian nama/negara
        $ports = Port::with('country')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('code', 'like', "%{$search}%");
            })
            ->when($countryId, function ($query, $countryId) {
                return $query->where('country_id', $countryId);
            })
            ->get();

        // Menyusun format JSON yang rapi untuk dibaca oleh Leaflet.js
        $formattedPorts = $ports->map(function ($port) {
            return [
                'id' => $port->id,
                'name' => $port->name,
                'code' => $port->code,
                'latitude' => (float) $port->latitude,
                'longitude' => (float) $port->longitude,
                'country' => $port->country ? $port->country->name : 'Unknown',
                'flag_url' => $port->country ? 'https://flagcdn.com/w40/' . strtolower($port->country->code) . '.png' : null
            ];
        });

        return response()->json($formattedPorts);
    }
}