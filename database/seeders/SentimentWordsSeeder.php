<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SentimentWordsSeeder extends Seeder
{
    public function run(): void
    {
        // Data Kata Positif bawaan dokumen PDF
        $positiveWords = ['growth', 'increase', 'profit', 'stable', 'improve', 'safe', 'success', 'boom', 'efficient', 'secure'];
        
        // Data Kata Negatif bawaan dokumen PDF
        $negativeWords = ['war', 'crisis', 'inflation', 'delay', 'disaster', 'conflict', 'strike', 'congested', 'risk', 'blockade'];

        foreach ($positiveWords as $word) {
            DB::table('positive_words')->updateOrInsert(['word' => $word], ['created_at' => now(), 'updated_at' => now()]);
        }

        foreach ($negativeWords as $word) {
            DB::table('negative_words')->updateOrInsert(['word' => $word], ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}