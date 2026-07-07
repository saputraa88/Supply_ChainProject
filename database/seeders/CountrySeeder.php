<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Indonesia',
                'code' => 'ID',
                'capital' => 'Jakarta',
                'region' => 'Asia',
                'currency' => 'IDR',
                'currency_symbol' => 'Rp',
                'latitude' => -6.2000,
                'longitude' => 106.8166,
                'flag' => 'https://flagcdn.com/id.svg',
                'population' => 281000000,
            ],
            [
                'name' => 'Singapore',
                'code' => 'SG',
                'capital' => 'Singapore',
                'region' => 'Asia',
                'currency' => 'SGD',
                'currency_symbol' => '$',
                'latitude' => 1.3521,
                'longitude' => 103.8198,
                'flag' => 'https://flagcdn.com/sg.svg',
                'population' => 6000000,
            ],
            [
                'name' => 'Malaysia',
                'code' => 'MY',
                'capital' => 'Kuala Lumpur',
                'region' => 'Asia',
                'currency' => 'MYR',
                'currency_symbol' => 'RM',
                'latitude' => 3.1390,
                'longitude' => 101.6869,
                'flag' => 'https://flagcdn.com/my.svg',
                'population' => 34000000,
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}