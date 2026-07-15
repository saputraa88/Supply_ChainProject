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
        // Rumus sederhana: suhu ekstrem (<10 atau >35) dan angin kencang menaikkan tingkat risiko
        $weatherRisk = min(100, max(10, round(($wind * 1.8) + abs($temp - 24) * 2.5)));

        // 4. Menghitung Risiko Komponen 2: Inflasi Negara (Bobot 20%)
        // Simulasi inflasi realistis berdasarkan tingkat kestabilan wilayah negara
        if (in_array($codeClean, ['AF', 'YE', 'SY', 'UA', 'SD'])) {
            $inflationRate = round(rand(250, 750) / 10, 1); // Inflasi tinggi di wilayah konflik (25% - 75%)
            $inflationRisk = min(100, round($inflationRate * 1.3));
        } else {
            $inflationRate = round(rand(15, 85) / 10, 1); // Negara stabil (1.5% - 8.5%)
            $inflationRisk = min(100, round($inflationRate * 8));
        }

        // 5. Menghitung Risiko Komponen 3: Sentimen Berita Geopolitik / Lexicon Intelligence (Bobot 40%)
        // Menyusun simulasi umpan berita RSS dinamis dan kalkulasi kata positif/negatif
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

        // Menentukan Tingkat Kategori Risiko untuk tampilan radar & warna badge
        if ($totalRisk >= 70) {
            $riskLevel = 'High Risk';
        } elseif ($totalRisk >= 40) {
            $riskLevel = 'Medium Risk';
        } else {
            $riskLevel = 'Low Risk';
        }

        // Susun sebagai ARRAY murni agar pas dengan sintaksis array pada file Blade Anda
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

        // 8. Kirim seluruh variabel yang dibutuhkan Blade menggunakan compact()
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
     * Helper PHP untuk melakukan parsing koordinat dari database (mengatasi 'N', 'S', 'E', 'W')
     */
    private function parseCoordinatePhp($coordStr, $isLongitude)
    {
        if (empty($coordStr)) return 0;
        
        // Ambil semua angka dan titik desimal saja
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

        // Kamus cadangan offline
        $fallbackData = [
            'AF' => ['region' => 'Asia', 'currency' => 'Afghan afghani'],
            'ID' => ['region' => 'Asia', 'currency' => 'Indonesian rupiah'],
            'US' => ['region' => 'Americas', 'currency' => 'United States dollar'],
            'GB' => ['region' => 'Europe', 'currency' => 'British pound'],
            'UA' => ['region' => 'Europe', 'currency' => 'Ukrainian hryvnia'],
            'YE' => ['region' => 'Asia', 'currency' => 'Yemeni rial'],
            'SY' => ['region' => 'Asia', 'currency' => 'Syrian pound'],
            'SD' => ['region' => 'Africa', 'currency' => 'Sudanese pound']
            // ... (simpan kamus fallback Anda sebelumnya di sini untuk kelengkapan)
        ];

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->get('https://restcountries.com/v3.1/all?fields=cca2,region,currencies');

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

            if ($isApiSuccess && isset($apiMap[$codeClean])) {
                $apiData = $apiMap[$codeClean];
                $region = $apiData['region'] ?? 'Global Area';
                
                if (!empty($apiData['currencies'])) {
                    $currencyKey = array_key_first($apiData['currencies']);
                    $currencyName = $apiData['currencies'][$currencyKey]['name'] ?? 'Local Currency';
                }
            } 
            elseif (isset($fallbackData[$codeClean])) {
                $region = $fallbackData[$codeClean]['region'];
                $currencyName = $fallbackData[$codeClean]['currency'];
            }

            if ($region !== 'Global Area' || $currencyName !== 'Local Currency') {
                $country->update([
                    'region'   => $region,
                    'currency' => $currencyName,
                ]);
                $updatedCount++;
            }
        }

        $sourceText = $isApiSuccess ? "langsung dari API RestCountries" : "menggunakan Kamus Cadangan Lokal (Offline Fallback)";
        
        return redirect()->route('countries.index')
            ->with('success', "Sukses! Berhasil menyinkronkan {$updatedCount} data negara {$sourceText}!");
    }
}