<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' sebagai Primary Key
            $table->string('name'); // Kolom untuk nama negara [cite: 65]
            $table->string('currency_code')->nullable(); // Kolom untuk kode mata uang [cite: 66]
            $table->string('region')->nullable(); // Kolom untuk wilayah/region [cite: 67]
            $table->string('language')->nullable(); // Kolom untuk bahasa [cite: 68]
            $table->timestamps(); // Otomatis membuat kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Batalkan migrasi (menghapus tabel).
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};