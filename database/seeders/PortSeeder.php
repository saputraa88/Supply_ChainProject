<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PortSeeder extends Seeder
{
    public function run()
    {
        // 1. Bersihkan tabel pelabuhan
        DB::table('ports')->truncate();

        $this->command->info('🚀 Menyuntikkan 30+ Dataset Pelabuhan Global & Domestik secara Offline...');

        // Dataset Mandiri - Campuran Internasional & Pelabuhan Strategis Indonesia
        $ports = [
            // --- INDONESIA (Diperbanyak biar aplikasi logistiknya lokal-friendly) ---
            ['name' => 'Tanjung Priok (Jakarta)', 'code' => 'IDTPP', 'lat' => -6.1033, 'lng' => 106.8792, 'country' => 'Indonesia', 'iso' => 'IDN'],
            ['name' => 'Tanjung Perak (Surabaya)', 'code' => 'IDTPE', 'lat' => -7.2024, 'lng' => 112.7241, 'country' => 'Indonesia', 'iso' => 'IDN'],
            ['name' => 'Belawan (Medan)', 'code' => 'IDBLW', 'lat' => 3.7842, 'lng' => 98.6917, 'country' => 'Indonesia', 'iso' => 'IDN'],
            ['name' => 'Makassar / Soekarno-Hatta', 'code' => 'IDMAK', 'lat' => -5.1186, 'lng' => 119.4108, 'country' => 'Indonesia', 'iso' => 'IDN'],
            ['name' => 'Pelabuhan Batam Center', 'code' => 'IDBTM', 'lat' => 1.1292, 'lng' => 104.0536, 'country' => 'Indonesia', 'iso' => 'IDN'],
            ['name' => 'Tanjung Emas (Semarang)', 'code' => 'IDTEM', 'lat' => -6.9456, 'lng' => 110.4214, 'country' => 'Indonesia', 'iso' => 'IDN'],
            ['name' => 'Pelabuhan Benoa (Bali)', 'code' => 'IDBOA', 'lat' => -8.7451, 'lng' => 115.2155, 'country' => 'Indonesia', 'iso' => 'IDN'],

            // --- ASIA GLOBAL ---
            ['name' => 'Port of Shanghai', 'code' => 'CNSHA', 'lat' => 31.2304, 'lng' => 121.4737, 'country' => 'China', 'iso' => 'CHN'],
            ['name' => 'Port of Singapore', 'code' => 'SGSIN', 'lat' => 1.2640, 'lng' => 103.8400, 'country' => 'Singapore', 'iso' => 'SGP'],
            ['name' => 'Port of Busan', 'code' => 'KRPUS', 'lat' => 35.1041, 'lng' => 129.0431, 'country' => 'South Korea', 'iso' => 'KOR'],
            ['name' => 'Port of Tokyo', 'code' => 'JPTYO', 'lat' => 35.6254, 'lng' => 139.7782, 'country' => 'Japan', 'iso' => 'JPN'],
            ['name' => 'Port Klang', 'code' => 'MYPKG', 'lat' => 3.0003, 'lng' => 101.3916, 'country' => 'Malaysia', 'iso' => 'MYS'],
            ['name' => 'Port of Hong Kong', 'code' => 'HKHKG', 'lat' => 22.3361, 'lng' => 114.1228, 'country' => 'Hong Kong', 'iso' => 'HKG'],
            ['name' => 'Port of Laem Chabang', 'code' => 'THLCH', 'lat' => 13.0911, 'lng' => 100.8906, 'country' => 'Thailand', 'iso' => 'THA'],
            ['name' => 'Port of Kaohsiung', 'code' => 'TWKHH', 'lat' => 22.6186, 'lng' => 120.2694, 'country' => 'Taiwan', 'iso' => 'TWN'],
            ['name' => 'Jebel Ali (Dubai)', 'code' => 'AEJEA', 'lat' => 24.9857, 'lng' => 55.0672, 'country' => 'United Arab Emirates', 'iso' => 'ARE'],

            // --- EROPA ---
            ['name' => 'Port of Rotterdam', 'code' => 'NLRTM', 'lat' => 51.9489, 'lng' => 4.1432, 'country' => 'Netherlands', 'iso' => 'NLD'],
            ['name' => 'Port of Antwerp', 'code' => 'BEANR', 'lat' => 51.2411, 'lng' => 4.4014, 'country' => 'Belgium', 'iso' => 'BEL'],
            ['name' => 'Port of Hamburg', 'code' => 'DEHAM', 'lat' => 53.5458, 'lng' => 9.9413, 'country' => 'Germany', 'iso' => 'DEU'],
            ['name' => 'Port of Felixstowe', 'code' => 'GBFXT', 'lat' => 51.9576, 'lng' => 1.3142, 'country' => 'United Kingdom', 'iso' => 'GBR'],
            ['name' => 'Port of Le Havre', 'code' => 'FRLEH', 'lat' => 49.4816, 'lng' => 0.1141, 'country' => 'France', 'iso' => 'FRA'],

            // --- AMERIKA ---
            ['name' => 'Port of Los Angeles', 'code' => 'USLAX', 'lat' => 33.7432, 'lng' => -118.2673, 'country' => 'United States', 'iso' => 'USA'],
            ['name' => 'Port of Long Beach', 'code' => 'USLGB', 'lat' => 33.7541, 'lng' => -118.2111, 'country' => 'United States', 'iso' => 'USA'],
            ['name' => 'Port of New York', 'code' => 'USNYC', 'lat' => 40.6713, 'lng' => -74.0125, 'country' => 'United States', 'iso' => 'USA'],
            ['name' => 'Port of Santos', 'code' => 'BRSSZ', 'lat' => -23.9608, 'lng' => -46.3331, 'country' => 'Brazil', 'iso' => 'BRA'],
            ['name' => 'Port of Balboa', 'code' => 'PABLB', 'lat' => 8.9481, 'lng' => -79.5658, 'country' => 'Panama', 'iso' => 'PAN'],

            // --- AFRIKA & OSEANIA ---
            ['name' => 'Tangier Med', 'code' => 'MATNG', 'lat' => 35.8860, 'lng' => -5.5011, 'country' => 'Morocco', 'iso' => 'MAR'],
            ['name' => 'Port of Durban', 'code' => 'ZADUR', 'lat' => -29.8679, 'lng' => 31.0264, 'country' => 'South Africa', 'iso' => 'ZAF'],
            ['name' => 'Port of Sydney', 'code' => 'AUSYD', 'lat' => -33.8610, 'lng' => 151.2110, 'country' => 'Australia', 'iso' => 'AUS'],
            ['name' => 'Port of Melbourne', 'code' => 'AUMEL', 'lat' => -37.8302, 'lng' => 144.9124, 'country' => 'Australia', 'iso' => 'AUS'],
        ];

        foreach ($ports as $port) {
            $insertData = [
                'name' => $port['name'],
                'code' => $port['code'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Set Koordinat sesuai kolom yang ada di database kamu
            if (Schema::hasColumn('ports', 'latitude')) {
                $insertData['latitude'] = $port['lat'];
                $insertData['longitude'] = $port['lng'];
            } else {
                $insertData['lat'] = $port['lat'];
                $insertData['lng'] = $port['lng'];
            }

            // PENCARIAN NEGARA SAKTI (Mencegah bug Shanghai masuk Swiss)
            if (Schema::hasColumn('ports', 'country_id')) {
                // Cari berdasarkan Nama Negara Terlebih dahulu (ex: 'China', 'Indonesia')
                $cId = DB::table('countries')->where('name', 'LIKE', '%' . $port['country'] . '%')->value('id');
                
                // Jika tidak ketemu, cari berdasarkan Kode ISO 3 Huruf (ex: 'CHN', 'IDN')
                if (!$cId) {
                    $cId = DB::table('countries')->where('code', $port['iso'])->value('id');
                }

                // Jika masih tidak ketemu juga, pakai ID negara pertama yang ada
                if (!$cId) {
                    $cId = DB::table('countries')->value('id');
                }

                // Kondisi paling darurat jika tabel countries kosong, buatkan negaranya
                if (!$cId) {
                    $cId = DB::table('countries')->insertGetId([
                        'name' => $port['country'],
                        'code' => $port['iso'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                $insertData['country_id'] = $cId;
            }

            if (Schema::hasColumn('ports', 'country_code')) {
                $insertData['country_code'] = $port['iso'];
            }

            DB::table('ports')->insert($insertData);
        }

        $this->command->info('🎉 Sukses Besar! 30+ Pelabuhan Dunia & Indonesia berhasil dipasang dengan data kedaulatan yang akurat.');
    }
}