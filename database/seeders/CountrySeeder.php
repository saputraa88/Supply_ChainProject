<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Matikan pengecekan foreign key sementara agar MySQL mengizinkan Truncate
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Panggil instance dari package PragmaRX Countries
        $countriesPackage = new \PragmaRX\Countries\Package\Countries();
        
        // Mengubah seluruh objek package menjadi Array Murni (Deep Array conversion)
        $allCountries = json_decode(json_encode($countriesPackage->all()), true);

        // 3. Lakukan perulangan untuk menyimpan data ke database lokal
        foreach ($allCountries as $item) {
            
            $code = $item['cca2'] ?? null;
            if (!$code) continue;

            // --- PARSER NAMA NEGARA ---
            $countryName = $item['name']['common'] ?? $item['name']['official'] ?? 'Unknown';

            // --- PARSER IBU KOTA ---
            $capitalName = null;
            if (isset($item['capital'])) {
                $capitalName = is_array($item['capital']) ? collect($item['capital'])->first() : $item['capital'];
            }

            // --- PARSER REGION ---
            $regionName = $item['region'] ?? $item['subregion'] ?? '-';

            // --- PARSER MATA UANG & SIMBOL ---
            $currencyName = null;
            $currencySymbol = null;
            if (isset($item['currencies']) && is_array($item['currencies']) && !empty($item['currencies'])) {
                // Mengambil kode key pertama (misal: IDR, USD, AFN)
                $firstKey = array_key_first($item['currencies']);
                if ($firstKey && isset($item['currencies'][$firstKey])) {
                    $currencyName = $item['currencies'][$firstKey]['name'] ?? null;
                    $currencySymbol = $item['currencies'][$firstKey]['symbol'] ?? null;
                }
            }

            // --- PARSER POPULASI ---
            $population = $item['population'] ?? null;

            // --- PARSER KOORDINAT ---
            $latitude = $item['geo']['latitude'] ?? null;
            $longitude = $item['geo']['longitude'] ?? null;

            // 4. Simpan ke database
            Country::create([
                'name'            => $countryName,
                'code'            => strtoupper($code),
                'capital'         => $capitalName,
                'region'          => $regionName,
                'currency'        => $currencyName,
                'currency_symbol' => $currencySymbol,
                'latitude'        => $latitude ? (string)$latitude : null,
                'longitude'       => $longitude ? (string)$longitude : null,
                'flag'            => "https://flagcdn.com/w160/" . strtolower($code) . ".png",
                'population'      => $population,
            ]);
        }
    }
}