<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port; // 1. Pastikan mengimpor Model Port di bagian atas! ⚓
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCountries()
    {
        $countries = Country::select('id', 'name', 'code', 'latitude', 'longitude')->orderBy('name')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Data koordinat negara berhasil dimuat',
            'total_data' => $countries->count(),
            'data' => $countries
        ], 200);
    }

    public function getRisk()
    {
        $countries = Country::all();
        $riskData = $countries->map(function($country) {
            $code = strtolower(trim($country->code));
            $inflation = ($code === 'af') ? 14.7 : 3.8;
            $weatherRisk = 30;
            $newsRisk = ($code === 'af') ? 80 : 35; 
            $currencyRisk = 40;

            $totalRisk = ($weatherRisk * 0.30) + ($inflation * 2.5 * 0.20) + ($newsRisk * 0.40) + ($currencyRisk * 0.10);
            
            return [
                'country_id' => $country->id,
                'country_name' => $country->name,
                'country_code' => $country->code,
                'total_risk_score' => round($totalRisk, 1),
                'risk_status' => $totalRisk < 35 ? 'Low Risk' : ($totalRisk < 65 ? 'Medium Risk' : 'High Risk')
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Intelijen prediksi risiko rantai pasok global berhasil diekstrak',
            'data' => $riskData
        ], 200);
    }

    /**
     * Endpoint: GET /api/ports
     * Menyajikan data koordinat pelabuhan riil berdasarkan input pencarian & filter negara
     */
    public function getPorts(Request $request) // 2. Tambahkan Request untuk membaca filter pencarian
    {
        $search = $request->query('search');
        $countryId = $request->query('country_id');

        // 3. Query data dari database dengan eager loading relasi 'country'
        $ports = Port::with('country')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($countryId, function ($query, $countryId) {
                return $query->where('country_id', $countryId);
            })
            ->get();

        // 4. Kembalikan langsung array koleksi pelabuhan agar kompatibel dengan JS: ports.forEach()
        return response()->json($ports);
    }

    public function getNews()
    {
        $news = [
            ['title' => 'Geopolitical tension triggers route changes in global cargo ships', 'impact' => 'Negative'],
            ['title' => 'New trade agreement reduces customs clearance times by 15%', 'impact' => 'Positive'],
            ['title' => 'Extreme weather forecast warns of potential port closure in Asia', 'impact' => 'Negative']
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Feed berita logistik internasional berhasil ditarik',
            'total_data' => count($news),
            'data' => $news
        ], 200);
    }
}