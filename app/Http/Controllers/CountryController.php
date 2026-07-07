<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Menampilkan daftar negara.
     */
    public function index()
    {
        $countries = Country::latest()->paginate(10);

        return view('countries.index', compact('countries'));
    }

    /**
     * Menampilkan form tambah negara.
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Menyimpan negara baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:countries',
        ]);

        Country::create($request->all());

        return redirect()->route('countries.index')
            ->with('success', 'Negara berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail negara.
     */
    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    /**
     * Update data negara.
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:countries,code,' . $country->id,
        ]);

        $country->update($request->all());

        return redirect()->route('countries.index')
            ->with('success', 'Negara berhasil diperbarui.');
    }

    /**
     * Hapus negara.
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->route('countries.index')
            ->with('success', 'Negara berhasil dihapus.');
    }
}