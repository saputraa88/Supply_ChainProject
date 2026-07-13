<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryListController extends Controller
{
    /**
     * Menampilkan detail satu negara spesifik.
     */
    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }
}