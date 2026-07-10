<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = new Countries();

        foreach ($countries->all() as $country) {

            $currency = null;
            $symbol = null;

            if (isset($country->currencies) && count($country->currencies) > 0) {
                $firstCurrency = collect($country->currencies)->first();

                $currency = $firstCurrency->iso_4217 ?? null;
                $symbol = $firstCurrency->units->major->symbol ?? null;
            }

            Country::updateOrCreate(
                [
                    'code' => $country->cca2,
                ],
                [
                    'name' => $country->name->common ?? $country->name->official,
                    'capital' => $country->capital[0] ?? null,
                    'region' => $country->region ?? null,
                    'currency' => $currency,
                    'currency_symbol' => $symbol,
                    'latitude' => $country->latlng[0] ?? null,
                    'longitude' => $country->latlng[1] ?? null,
                    'flag' => "https://flagcdn.com/w80/" . strtolower($country->cca2) . ".png",
                    'population' => $country->population ?? 0,
                ]
            );
        }

        $this->command->info('Semua negara berhasil diimport.');
    }
}