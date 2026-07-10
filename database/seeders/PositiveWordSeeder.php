<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;

class PositiveWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = [
            'growth',
            'profit',
            'stable',
            'increase',
            'improve',
            'success',
            'safe',
            'strong',
            'positive',
            'recover',
        ];

        foreach ($words as $word) {

            PositiveWord::updateOrCreate(
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