<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NegativeWord;

class NegativeWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = [
            'crisis',
            'war',
            'storm',
            'inflation',
            'earthquake',
            'flood',
            'decline',
            'loss',
            'risk',
            'disaster',
        ];

        foreach ($words as $word) {

            NegativeWord::updateOrCreate(
                [
                    'word' => $word,
                ],
                [
                    'word' => $word,
                ]
            );

        }
    }
}