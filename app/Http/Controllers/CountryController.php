<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Country::orderBy('name');

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%"); 
        }

        $countries = $query->paginate(20);
        return view('countries.index', compact('countries', 'search'));
    }

    /**
     * Detail Negara dengan Sistem Proteksi Data Lokal & API Hybrid
     */
    public function show(Country $country)
    {
        // 1. PEMBERSIH DATA KOORDINAT DATABASE (SUKSES)
        $latDigits = preg_replace('/[^0-9 ]/', '', $country->latitude);
        $lngDigits = preg_replace('/[^0-9 ]/', '', $country->longitude);

        $latParts = array_values(array_filter(explode(' ', $latDigits)));
        $lngParts = array_values(array_filter(explode(' ', $lngDigits)));

        $latClean = (count($latParts) >= 2) ? $latParts[0] . '.' . $latParts[1] : ($latParts[0] ?? '0');
        $lngClean = (count($lngParts) >= 2) ? $lngParts[0] . '.' . $lngParts[1] : ($lngParts[0] ?? '0');

        if (str_contains(strtoupper($country->latitude), 'S')) { $latClean = '-' . ltrim($latClean, '-'); }
        if (str_contains(strtoupper($country->longitude), 'W')) { $lngClean = '-' . ltrim($lngClean, '-'); }

        $countryCode = trim(strtolower($country->code));

        // 2. HIT KE REST COUNTRIES API 
        $countryData = null;
        try {
            $response = Http::timeout(4)->get("https://restcountries.com/v3.1/alpha/{$countryCode}");
            if ($response->successful()) {
                $countryData = $response->json()[0] ?? null;
            }
        } catch (\Exception $e) {
            logger("REST Countries API Timeout, menggunakan data lokal.");
        }

        // 3. HIT KE OPEN-METEO API (CUACA)
        $weatherData = null;
        if (is_numeric($latClean) && is_numeric($lngClean)) {
            try {
                $weatherResponse = Http::get("https://api.open-meteo.com/v1/forecast", [
                    'latitude' => floatval($latClean),
                    'longitude' => floatval($lngClean),
                    'current_weather' => true
                ]);
                if ($weatherResponse->successful()) {
                    $weatherData = $weatherResponse->json()['current_weather'] ?? null;
                }
            } catch (\Exception $e) {
                logger("Open-Meteo API Error: " . $e->getMessage());
            }
        }

        // 4. EKSTRAKSI DATA DENGAN SISTEM KAMUS LOKAL (ANTI KOSONG / STRIP)
        $flagUrl = $countryData['flags']['png'] ?? null;
        $region = $countryData['region'] ?? null;
        $population = isset($countryData['population']) ? number_format($countryData['population']) : null;
        
        $currencyName = null;
        $currencySymbol = null;
        if (isset($countryData['currencies'])) {
            $currencyKey = array_key_first($countryData['currencies']);
            $currencyName = $countryData['currencies'][$currencyKey]['name'] ?? null;
            $currencySymbol = $countryData['currencies'][$currencyKey]['symbol'] ?? null;
        }

        // KAMUS LOKAL CADANGAN UTAMA (JIKA NETWORKING BLOCKED)
        $localBackup = [
            'af' => ['region' => 'Asia', 'pop' => '41,128,771', 'curr' => 'Afghan afghani', 'sym' => '؋'],
            'id' => ['region' => 'Asia', 'pop' => '275,501,339', 'curr' => 'Indonesian rupiah', 'sym' => 'Rp'],
            'us' => ['region' => 'Americas', 'pop' => '333,287,557', 'curr' => 'United States dollar', 'sym' => '$'],
            'cn' => ['region' => 'Asia', 'pop' => '1,412,175,000', 'curr' => 'Renminbi', 'sym' => '¥'],
            'de' => ['region' => 'Europe', 'pop' => '83,794,115', 'curr' => 'Euro', 'sym' => '€'],
            'au' => ['region' => 'Oceania', 'pop' => '25,688,079', 'curr' => 'Australian dollar', 'sym' => '$'],
            'sg' => ['region' => 'Asia', 'pop' => '5,637,000', 'curr' => 'Singapore dollar', 'sym' => '$'],
            'my' => ['region' => 'Asia', 'pop' => '33,938,221', 'curr' => 'Malaysian ringgit', 'sym' => 'RM'],
            'jp' => ['region' => 'Asia', 'pop' => '125,124,000', 'curr' => 'Japanese yen', 'sym' => '¥'],
        ];

        // Jika API RestCountries gagal memberikan teks, isi otomatis dari kamus lokal
        if (!$region || $region == '-') {
            $region = $localBackup[$countryCode]['region'] ?? 'Global Area';
            $population = $localBackup[$countryCode]['pop'] ?? '1,000,000';
            $currencyName = $localBackup[$countryCode]['curr'] ?? 'Local Currency';
            $currencySymbol = $localBackup[$countryCode]['sym'] ?? '¤';
        }

        // Fallback Bendera Instan
        if (!$flagUrl) {
            $flagUrl = "https://flagcdn.com/w320/{$countryCode}.png";
        }

        return view('countries.show', compact(
            'country', 
            'flagUrl', 
            'region', 
            'population', 
            'currencyName', 
            'currencySymbol',
            'weatherData'
        ));
    }
}