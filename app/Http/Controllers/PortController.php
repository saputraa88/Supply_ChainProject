<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\Country;
use Illuminate\Http\Request;

class PortController extends Controller
{
    /**
     * Menampilkan daftar semua pelabuhan
     */
    public function index()
    {
        // Mengambil semua data pelabuhan beserta data negara relasingya
        $ports = Port::with('country')->get();

        // Mengarahkan ke file resources/views/ports/index.blade.php
        return view('ports.index', compact('ports'));
    }

    /**
     * Menampilkan form registrasi pelabuhan baru
     */
    public function create()
    {
        return view('ports.create');
    }

    /**
     * Menyimpan data pelabuhan baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'country_id' => 'required|exists:countries,id',
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
}