<?php

namespace App\Http\Controllers;

use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Menampilkan daftar seluruh negara.
     */
    public function index()
    {
        $countries = Country::orderBy('name')->paginate(20);

        return view('countries.index', compact('countries'));
    }
}