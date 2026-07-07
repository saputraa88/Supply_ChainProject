<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\WeatherLog;
use App\Models\EconomicData;
use App\Models\RiskScore;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'countryCount' => Country::count(),
            'portCount' => Port::count(),
            'weatherCount' => WeatherLog::count(),
            'economicCount' => EconomicData::count(),
            'riskCount' => RiskScore::count(),
        ]);
    }
}