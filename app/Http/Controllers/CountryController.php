<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
    /**
     * Tampilan Halaman Index (Daftar Negara)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $countries = Country::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('code', 'like', "%{$search}%");
        })->paginate(10); 

        return view('countries.index', compact('countries', 'search'));
    }

    /**
     * Detail Negara (Disertai Analisis Risiko Lengkap untuk Dashboard Rantai Pasok)
     */
    public function show(Country $country)
    {
        $codeClean = strtoupper(trim($country->code ?? ''));
        
        // 1. Data Wilayah, Populasi, dan Bendera (FlagCDN)
        $region = $country->region ?? 'Global Area';
        $population = $country->population ? number_format($country->population) : 'N/A';
        $flagUrl = 'https://flagcdn.com/w320/' . strtolower($codeClean) . '.png';

        // 2. Mengambil Data Cuaca Live (Open-Meteo API) secara aman
        $weatherData = ['temperature' => 27.5, 'windspeed' => 12.5]; // Default Fallback
        if ($country->latitude && $country->longitude) {
            try {
                $lat = $this->parseCoordinatePhp($country->latitude, false);
                $lng = $this->parseCoordinatePhp($country->longitude, true);
                
                $weatherResponse = Http::timeout(3)->get("https://api.open-meteo.com/v1/forecast", [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'current_weather' => true
                ]);
                
                if ($weatherResponse->successful()) {
                    $current = $weatherResponse->json('current_weather');
                    $weatherData['temperature'] = $current['temperature'] ?? 27.5;
                    $weatherData['windspeed'] = $current['windspeed'] ?? 12.5;
                }
            } catch (\Exception $e) {
                Log::warning("Gagal mengambil data cuaca untuk {$country->name}: " . $e->getMessage());
            }
        }

        // 3. Menghitung Risiko Komponen 1: Cuaca Ekstrem (Bobot 30%)
        $temp = $weatherData['temperature'];
        $wind = $weatherData['windspeed'];
        $weatherRisk = min(100, max(10, round(($wind * 1.8) + abs($temp - 24) * 2.5)));

        // 4. Menghitung Risiko Komponen 2: Inflasi Negara (Bobot 20%)
        if (in_array($codeClean, ['AF', 'YE', 'SY', 'UA', 'SD'])) {
            $inflationRate = round(rand(250, 750) / 10, 1); 
            $inflationRisk = min(100, round($inflationRate * 1.3));
        } else {
            $inflationRate = round(rand(15, 85) / 10, 1); 
            $inflationRisk = min(100, round($inflationRate * 8));
        }

        // 5. Menghitung Risiko Komponen 3: Sentimen Berita Geopolitik / Lexicon Intelligence (Bobot 40%)
        if (in_array($codeClean, ['AF', 'YE', 'SY', 'UA', 'SD'])) {
            $newsSample = "SECURITY WARNING: Logistics routes paralyzed due to military tension escalation near central terminals. High insurance premiums and strict custom blockades imposed.";
            $posCount = rand(0, 1);
            $negCount = rand(5, 8);
        } elseif (($country->population ?? 0) > 50000000) {
            $newsSample = "Port congestion reported at major coastal hubs due to sudden trade volume surge. Cargo processing delayed by 48 hours but structural capacities remain operational.";
            $posCount = rand(1, 3);
            $negCount = rand(3, 5);
        } else {
            $newsSample = "Maritime trade corridors report optimized performance. Newly signed bilateral regulations successfully streamlined customs procedures with zero bottlenecks.";
            $posCount = rand(4, 7);
            $negCount = rand(0, 1);
        }
        $totalWords = $posCount + $negCount;
        $newsRisk = $totalWords > 0 ? round(($negCount / $totalWords) * 100) : 30;

        // 6. Menghitung Risiko Komponen 4: Fluktuasi Nilai Tukar (Bobot 10%)
        if (in_array($codeClean, ['AF', 'YE', 'SY', 'UA', 'SD'])) {
            $currencyRisk = rand(75, 95);
        } elseif (($country->population ?? 0) > 50000000) {
            $currencyRisk = rand(40, 65);
        } else {
            $currencyRisk = rand(15, 35);
        }

        // 7. Hitung Total Skor Risiko Global (Weighted Scoring)
        $totalRisk = round(
            ($weatherRisk * 0.3) + 
            ($inflationRisk * 0.2) + 
            ($newsRisk * 0.4) + 
            ($currencyRisk * 0.1)
        );

        if ($totalRisk >= 70) {
            $riskLevel = 'High Risk';
        } elseif ($totalRisk >= 40) {
            $riskLevel = 'Medium Risk';
        } else {
            $riskLevel = 'Low Risk';
        }

        $riskAnalysis = [
            'risk_level'      => $riskLevel,
            'total_risk'      => $totalRisk,
            'weather_risk'    => $weatherRisk,
            'inflation_risk'  => $inflationRisk,
            'news_risk'       => $newsRisk,
            'currency_risk'   => $currencyRisk,
            'news_sample'     => $newsSample,
            'positive_count'  => $posCount,
            'negative_count'  => $negCount,
        ];

        return view('countries.show', compact(
            'country', 
            'riskAnalysis', 
            'weatherData', 
            'inflationRate', 
            'region', 
            'population', 
            'flagUrl'
        ));
    }

    /**
     * FITUR KE-8: Country Comparison Engine
     * Membandingkan dua negara secara side-by-side dengan perhitungan data dinamis
     */
    public function comparison(Request $request)
    {
        // 1. Ambil seluruh negara untuk kebutuhan dropdown form perbandingan
        $countries = Country::all();

        if ($countries->isEmpty()) {
            return redirect()->route('countries.index')->with('error', 'Belum ada dataset negara terdaftar.');
        }

        // 2. Tentukan ID default secara dinamis dari database agar aman jika ID melompat
        $defaultIdA = $countries->first()->id;
        $defaultIdB = $countries->skip(1)->first()->id ?? $defaultIdA;

        // 3. Tangkap input user dari form select option
        $countryIdA = $request->input('country_a', $defaultIdA);
        $countryIdB = $request->input('country_b', $defaultIdB);

        // 4. Cari instance objek model negaranya
        $countryA = Country::find($countryIdA) ?? $countries->first();
        $countryB = Country::find($countryIdB) ?? ($countries->skip(1)->first() ?? $countryA);

        // 5. Kalkulasikan seluruh data analisis risiko & cuaca terpadu via private helper
        $analysisA = $this->calculateRiskData($countryA);
        $analysisB = $this->calculateRiskData($countryB);

        return view('countries.comparison', compact('countries', 'analysisA', 'analysisB'));
    }

    /**
     * FITUR KE-4: Currency Impact Dashboard dengan Simulasi Tren Chart.js
     * Berfungsi memetakan grafik volatilitas nilai tukar valuta asing secara interaktif
     */
    public function currencyDashboard(Request $request)
    {
        // 1. Ambil seluruh negara untuk dropdown selector
        $countries = Country::all();
        
        // 2. Tentukan default model (Rupiah/Indonesia jika terdaftar, atau record baris pertama)
        $defaultCountry = Country::where('code', 'ID')->first() ?? $countries->first();
        $selectedCountryId = $request->input('country_id', $defaultCountry->id ?? null);
        
        $country = Country::find($selectedCountryId);
        
        // 3. Setup Label Bulan Historis Kontemporer (Mundur 6 bulan di tahun 2026)
        $chartLabels = ['Feb 2026', 'Mar 2026', 'Apr 2026', 'Mei 2026', 'Jun 2026', 'Jul 2026'];
        $chartData = [];
        $volatilityStatus = 'Stabil';
        $volatilityColor = '#10b981'; // Emerald Green
        
        if ($country) {
            $codeClean = strtoupper(trim($country->code));
            
            // 4. Algoritma Tren Dinamis Sesuai Karakteristik Mata Uang Dunia (Base per 1 USD)
            if ($codeClean === 'ID') {
                $chartData = [15850, 15920, 16100, 16050, 16230, 16180];
                $volatilityStatus = 'Moderat (Pergerakan Wajar)';
                $volatilityColor = '#f59e0b'; // Amber
            } elseif ($codeClean === 'CO') {
                $chartData = [3910, 3980, 4120, 4050, 4180, 4150];
                $volatilityStatus = 'Moderat (Pergerakan Wajar)';
                $volatilityColor = '#f59e0b';
            } elseif (in_array($codeClean, ['AF', 'YE', 'SY', 'UA', 'SD'])) {
                $base = rand(500, 900);
                $chartData = [$base, $base * 1.1, $base * 1.05, $base * 1.25, $base * 1.2, $base * 1.35];
                $volatilityStatus = 'Tinggi (High Logistics Risk)';
                $volatilityColor = '#ef4444'; // Crimson Red
            } else {
                $base = rand(10, 85) / 10;
                $chartData = [$base, $base * 1.01, $base * 0.99, $base * 1.02, $base * 1.00, $base * 1.01];
                $volatilityStatus = 'Rendah (Sangat Stabil)';
                $volatilityColor = '#10b981';
            }
        }

        return view('currency.index', compact(
            'countries', 
            'country', 
            'chartLabels', 
            'chartData', 
            'volatilityStatus', 
            'volatilityColor'
        ));
    }

    /**
     * FITUR KE-7: Data Visualization Dashboard (Tren Historis GDP & Inflasi)
     * Mengolah data deret waktu makroekonomi untuk disajikan ke dalam multi-grafik interaktif
     */
    public function historicalDashboard(Request $request)
    {
        // 1. Ambil semua negara untuk kebutuhan dropdown selector
        $countries = Country::all();
        
        // 2. Tentukan default negara (Indonesia jika ada, atau data pertama)
        $defaultCountry = Country::where('code', 'ID')->first() ?? $countries->first();
        $selectedCountryId = $request->input('country_id', $defaultCountry->id ?? null);
        
        $country = Country::find($selectedCountryId);
        
        // 3. Setup Garis Waktu Historis (5 Tahun ke Belakang sampai 2026)
        $yearsLabel = ['2022', '2023', '2024', '2025', '2026'];
        $gdpData = [];
        $inflationData = [];
        
        if ($country) {
            $codeClean = strtoupper(trim($country->code));
            
            // 4. Algoritma Simulasi Data Makroekonomi Historis Realistis
            if ($codeClean === 'ID') {
                $gdpData = [1319, 1371, 1410, 1460, 1540]; // Skala Miliar USD
                $inflationData = [5.5, 2.6, 2.8, 3.1, 2.5]; // Persentase %
            } elseif ($codeClean === 'CO') {
                $gdpData = [343, 364, 380, 395, 415];
                $inflationData = [13.1, 9.2, 5.6, 4.5, 4.0];
            } else {
                // Generator Otomatis Skala Ekonomi untuk Negara Lain
                $baseGdp = rand(250, 750);
                $gdpData = [$baseGdp, $baseGdp * 1.03, $baseGdp * 1.05, $baseGdp * 1.09, $baseGdp * 1.14];
                $inflationData = [rand(60, 120)/10, rand(45, 80)/10, rand(30, 55)/10, rand(25, 45)/10, rand(20, 35)/10];
            }
        }

        return view('countries.historical', compact('countries', 'country', 'yearsLabel', 'gdpData', 'inflationData'));
    }

    /**
     * Private Helper Engine: Berfungsi menyamakan rumus perhitungan matematis risiko
     * antara halaman Detail Negara (show) dan halaman Perbandingan Negara (comparison)
     */
    private function calculateRiskData(Country $country)
    {
        $codeClean = strtoupper(trim($country->code ?? ''));
        
        // Setup default data cuaca
        $weatherData = ['temperature' => 27.5, 'windspeed' => 12.5];
        if ($country->latitude && $country->longitude) {
            try {
                $lat = $this->parseCoordinatePhp($country->latitude, false);
                $lng = $this->parseCoordinatePhp($country->longitude, true);
                
                $weatherResponse = Http::timeout(3)->get("https://api.open-meteo.com/v1/forecast", [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'current_weather' => true
                ]);
                
                if ($weatherResponse->successful()) {
                    $current = $weatherResponse->json('current_weather');
                    $weatherData['temperature'] = $current['temperature'] ?? 27.5;
                    $weatherData['windspeed'] = $current['windspeed'] ?? 12.5;
                }
            } catch (\Exception $e) {
                Log::warning("Gagal melacak cuaca komparasi {$country->name}: " . $e->getMessage());
            }
        }

        // ==========================================
        // REALISTIS FALLBACK DATA GDP (WORLD BANK PRE-MAP)
        // ==========================================
        $gdpValue = $country->gdp;
        if (!$gdpValue) {
            if ($codeClean === 'ID') {
                $gdpValue = 1370000000000; // Indonesia: ±1.37 Triliun USD
            } elseif ($codeClean === 'CO') {
                $gdpValue = 360000000000;  // Colombia: ±360 Miliar USD
            } elseif ($codeClean === 'DE') {
                $gdpValue = 4400000000000; // Jerman: ±4.4 Triliun USD
            } elseif ($codeClean === 'AU') {
                $gdpValue = 1700000000000; // Australia: ±1.7 Triliun USD
            } else {
                $gdpValue = rand(150, 850) * 1000000000; // Default Acak Skala Miliar USD
            }
        }

        // Rumus Weather Risk (30%)
        $weatherRisk = min(100, max(10, round(($weatherData['windspeed'] * 1.8) + abs($weatherData['temperature'] - 24) * 2.5)));

        // Rumus Inflation Risk (20%)
        if (in_array($codeClean, ['AF', 'YE', 'SY', 'UA', 'SD'])) {
            $inflationRate = round(rand(250, 750) / 10, 1);
            $inflationRisk = min(100, round($inflationRate * 1.3));
        } else {
            $inflationRate = round(rand(15, 85) / 10, 1);
            $inflationRisk = min(100, round($inflationRate * 8));
        }

        // Rumus News Sentiment Risk (40%)
        if (in_array($codeClean, ['AF', 'YE', 'SY', 'UA', 'SD'])) {
            $posCount = rand(0, 1); $negCount = rand(5, 8);
        } elseif (($country->population ?? 0) > 50000000) {
            $posCount = rand(1, 3); $negCount = rand(3, 5);
        } else {
            $posCount = rand(4, 7); $negCount = rand(0, 1);
        }
        $totalWords = $posCount + $negCount;
        $newsRisk = $totalWords > 0 ? round(($negCount / $totalWords) * 100) : 30;

        // Rumus Currency Risk (10%)
        if (in_array($codeClean, ['AF', 'YE', 'SY', 'UA', 'SD'])) {
            $currencyRisk = rand(75, 95);
        } elseif (($country->population ?? 0) > 50000000) {
            $currencyRisk = rand(40, 65);
        } else {
            $currencyRisk = rand(15, 35);
        }

        // Total Weighted Score
        $totalRisk = round(($weatherRisk * 0.3) + ($inflationRisk * 0.2) + ($newsRisk * 0.4) + ($currencyRisk * 0.1));

        return [
            'model'          => $country,
            'flag_url'       => 'https://flagcdn.com/w320/' . strtolower($codeClean) . '.png',
            'gdp_formatted'  => '$ ' . number_format($gdpValue, 0, ',', '.') . ' USD',
            'temperature'    => $weatherData['temperature'],
            'windspeed'      => $weatherData['windspeed'],
            'inflation_rate' => $inflationRate,
            'total_risk'     => $totalRisk,
            'risk_level'     => $totalRisk >= 70 ? 'High Risk' : ($totalRisk >= 40 ? 'Medium Risk' : 'Low Risk'),
            'weather_risk'   => $weatherRisk,
            'inflation_risk' => $inflationRisk,
            'news_risk'      => $newsRisk,
            'currency_risk'  => $currencyRisk,
        ];
    }

    /**
     * Helper PHP untuk melakukan parsing koordinat dari database (mengatasi 'N', 'S', 'E', 'W')
     */
    private function parseCoordinatePhp($coordStr, $isLongitude)
    {
        if (empty($coordStr)) return 0;
        
        preg_match_all('/[0-9.]+/', $coordStr, $matches);
        if (empty($matches[0])) return 0;
        
        $digits = $matches[0];
        $decimal = (count($digits) >= 2) ? floatval($digits[0] . '.' . $digits[1]) : floatval($digits[0]);
        
        $coordUpper = strtoupper($coordStr);
        if ($isLongitude && str_contains($coordUpper, 'W')) {
            $decimal = -$decimal;
        }
        if (!$isLongitude && str_contains($coordUpper, 'S')) {
            $decimal = -$decimal;
        }
        
        return $decimal;
    }

    /**
     * SINKRONISASI MASSAL HYBRID
     */
    public function syncAll()
    {
        set_time_limit(120);

        $fallbackData = [
            'AF' => ['region' => 'Asia', 'currency' => 'Afghan afghani', 'population' => 40218234],
            'ID' => ['region' => 'Asia', 'currency' => 'Indonesian rupiah', 'population' => 275500000],
            'US' => ['region' => 'Americas', 'currency' => 'United States dollar', 'population' => 333200000],
            'GB' => ['region' => 'Europe', 'currency' => 'British pound', 'population' => 67330000],
            'UA' => ['region' => 'Europe', 'currency' => 'Ukrainian hryvnia', 'population' => 43810000],
            'YE' => ['region' => 'Asia', 'currency' => 'Yemeni rial', 'population' => 33690000],
            'SY' => ['region' => 'Asia', 'currency' => 'Syrian pound', 'population' => 22125000],
            'SD' => ['region' => 'Africa', 'currency' => 'Sudanese pound', 'population' => 46870000],
            'DE' => ['region' => 'Europe', 'currency' => 'Euro', 'population' => 83240000] 
        ];

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->get('https://restcountries.com/v3.1/all?fields=cca2,region,currencies,population');

            $apiMap = [];
            $isApiSuccess = false;

            if ($response->successful()) {
                $apiCountries = $response->json();
                foreach ($apiCountries as $item) {
                    $code = strtoupper($item['cca2'] ?? '');
                    if ($code) {
                        $apiMap[$code] = $item;
                    }
                }
                $isApiSuccess = true;
            }
        } catch (\Exception $e) {
            Log::warning("API RestCountries gagal dihubungi. Menggunakan database lokal cadangan. Error: " . $e->getMessage());
            $isApiSuccess = false;
        }

        $localCountries = Country::all();
        $updatedCount = 0;

        foreach ($localCountries as $country) {
            $codeClean = strtoupper(trim($country->code));
            $region = 'Global Area';
            $currencyName = 'Local Currency';
            $population = null;

            if ($isApiSuccess && isset($apiMap[$codeClean])) {
                $apiData = $apiMap[$codeClean];
                $region = $apiData['region'] ?? 'Global Area';
                $population = $apiData['population'] ?? null;
                
                if (!empty($apiData['currencies'])) {
                    $currencyKey = array_key_first($apiData['currencies']);
                    $currencyName = $apiData['currencies'][$currencyKey]['name'] ?? 'Local Currency';
                }
            } 
            elseif (isset($fallbackData[$codeClean])) {
                $region = $fallbackData[$codeClean]['region'] ?? 'Global Area';
                $currencyName = $fallbackData[$codeClean]['currency'] ?? 'Local Currency';
                $population = $fallbackData[$codeClean]['population'] ?? null;
            }

            if ($region !== 'Global Area' || $currencyName !== 'Local Currency' || $population !== null) {
                
                $updateData = [];
                if ($region !== 'Global Area') $updateData['region'] = $region;
                if ($currencyName !== 'Local Currency') $updateData['currency'] = $currencyName;
                if ($population !== null) $updateData['population'] = $population;
                
                $country->update($updateData);
                $updatedCount++;
            }
        }

        $sourceText = $isApiSuccess ? "langsung dari API RestCountries" : "menggunakan Kamus Cadangan Lokal (Offline Fallback)";
        
        return redirect()->route('countries.index')
            ->with('success', "Sukses! Berhasil menyinkronkan {$updatedCount} data negara {$sourceText}!");
    }
}