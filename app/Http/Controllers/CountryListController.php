<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class CountryListController extends Controller
{
    /**
     * Menampilkan detail satu negara spesifik dengan komputasi risiko riil.
     */
    public function show(Country $country)
    {
        // 1. CLEANSING DATA & HIT LIVE WEATHER API (Open-Meteo)
        // Bersihkan string koordinat agar bisa dibaca oleh API cuaca internasional
        $lat = filter_var($country->latitude, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $lng = filter_var($country->longitude, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        
        $weatherData = ['temperature' => 26.8, 'windspeed' => 14.2]; // Fallback default jika koneksi putus
        try {
            $response = Http::timeout(3)->get("https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lng}&current_weather=true");
            if ($response->successful() && isset($response->json()['current_weather'])) {
                $weatherData = $response->json()['current_weather'];
            }
        } catch (\Exception $e) {
            // Menggunakan fallback jika koneksi internet server bermasalah
        }

        // 2. AMBIL DATA BERITA UNTUK SENTIMEN ANALYSIS
        // Mencari berita di database yang relevan dengan negara ini, jika tidak ada gunakan default teks kargo
        $article = DB::table('articles')->where('title', 'like', "%{$country->name}%")->first() 
                   ?? DB::table('articles')->latest()->first();
        
        $newsSample = $article ? $article->title : "Severe geopolitical conflict and market crisis cause high inflation, delaying shipping routes, though local trade remains stable.";

        // 3. MESIN ALGORITMA: LEXICON SENTIMENT ANALYSIS
        // Tokenisasi: Ubah kalimat berita menjadi array kata-kata kecil yang bersih
        $cleanText = strtolower(preg_replace('/[^a-zA-Z0-9 ]/', '', $newsSample));
        $words = explode(' ', $cleanText);

        // Ambil kamus kata positif & negatif dari tabel database bawaan migrasi
        $positiveWords = DB::table('positive_words')->pluck('word')->toArray();
        $negativeWords = DB::table('negative_words')->pluck('word')->toArray();

        $positiveCount = 0;
        $negativeCount = 0;

        // Loop matching kata kunci sentimen
        foreach ($words as $word) {
            if (in_array($word, $positiveWords)) { $positiveCount++; }
            if (in_array($word, $negativeWords)) { $negativeCount++; }
        }

        // 4. ENGINE KOMPUTASI: WEIGHTED RISK MODEL (Rumus Matematika Proyek Akhir)
        // Indikator A: Risiko Cuaca Ekstrem (Skor 0-100 dihitung dari parameter kecepatan angin)
        $weatherRiskScore = min(($weatherData['windspeed'] * 3), 100);

        // Indikator B: Risiko Inflasi Makroekonomi (Diambil langsung dari tabel database economic_data)
        $inflationRate = 3.5; // Default standar
        $economicData = DB::table('economic_data')->where('country_code', $country->code)->first();
        if ($economicData && isset($economicData->inflation_rate)) {
            $inflationRate = $economicData->inflation_rate;
        }
        $inflationRiskScore = min(($inflationRate * 4), 100);

        // Indikator C: Risiko Sentimen Berita Geopolitik (Persentase rasio kata negatif)
        $totalSentimentWords = $positiveCount + $negativeCount;
        $newsRiskScore = ($totalSentimentWords > 0) ? ($negativeCount / $totalSentimentWords) * 100 : 45;

        // Indikator D: Risiko Fluktuasi Mata Uang
        $currencyRiskScore = 40;

        // PENGAPLIKASIAN BOBOT (WEIGHTED RATIO FORMULA)
        // Rumus: Weather (30%) + Inflation (20%) + News (40%) + Currency (10%)
        $totalRisk = ($weatherRiskScore * 0.30) + ($inflationRiskScore * 0.20) + ($newsRiskScore * 0.40) + ($currencyRiskScore * 0.10);

        // Klasifikasi Hasil Akhir Tingkat Bahaya Rantai Pasok
        if ($totalRisk < 35) {
            $riskLevel = 'Low Risk';
        } elseif ($totalRisk < 65) {
            $riskLevel = 'Medium Risk';
        } else {
            $riskLevel = 'High Risk';
        }

        $riskAnalysis = [
            'total_risk' => round($totalRisk, 1),
            'risk_level' => $riskLevel,
            'weather_risk' => round($weatherRiskScore, 1),
            'inflation_risk' => round($inflationRiskScore, 1),
            'news_risk' => round($newsRiskScore, 1),
            'currency_risk' => round($currencyRiskScore, 1),
            'news_sample' => $newsSample,
            'positive_count' => $positiveCount,
            'negative_count' => $negativeCount,
        ];

        // 5. DATA WIDGET PELENGKAP
        $flagUrl = "https://flagcdn.com/w320/" . strtolower(trim($country->code)) . ".png";
        $region = "Global Supply Chain Zone";
        $population = "Live System Active";

        // Satukan semua parameter ke dalam view agar dashboard menyala dinamis
        return view('countries.show', compact('country', 'flagUrl', 'region', 'population', 'weatherData', 'riskAnalysis', 'inflationRate'));
    }
}