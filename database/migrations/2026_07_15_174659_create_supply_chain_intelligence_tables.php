<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Kamus Kata Positif (Sesuai Halaman 7 PDF)
        Schema::create('positive_words', function (Blueprint $table) {
            $table->id();
            $table->string('word')->unique();
            $table->timestamps();
        });

        // 2. Tabel Kamus Kata Negatif (Sesuai Halaman 7 PDF)
        Schema::create('negative_words', function (Blueprint $table) {
            $table->id();
            $table->string('word')->unique();
            $table->timestamps();
        });

        // 3. Tabel Penyimpanan Skor Risiko Negara (Sesuai Halaman 8 PDF)
        Schema::create('risk_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->decimal('weather_risk', 5, 2)->default(0);
            $table->decimal('inflation_risk', 5, 2)->default(0);
            $table->decimal('news_risk', 5, 2)->default(0);
            $table->decimal('currency_risk', 5, 2)->default(0);
            $table->decimal('total_risk_score', 5, 2)->default(0);
            $table->string('risk_level')->default('Low Risk'); // Low, Medium, High Risk
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_scores');
        Schema::dropIfExists('negative_words');
        Schema::dropIfExists('positive_words');
    }
};