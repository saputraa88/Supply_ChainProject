<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryListController extends Controller
{
    /**
     * Menampilkan daftar semua negara.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $countries = Country::when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('countries.index', compact('countries', 'search'));
    }

    /**
     * Menampilkan detail negara.
     */
    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }
}