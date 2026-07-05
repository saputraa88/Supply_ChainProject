public function up(): void
{
    Schema::create('weather_logs', function (Blueprint $table) {
        $table->id();

        $table->foreignId('country_id')
              ->constrained('countries')
              ->cascadeOnDelete();

        $table->decimal('temperature', 5, 2)->nullable();
        $table->decimal('wind_speed', 5, 2)->nullable();
        $table->decimal('rainfall', 5, 2)->nullable();
        $table->integer('humidity')->nullable();
        $table->string('weather_code')->nullable();
        $table->decimal('storm_risk', 5, 2)->nullable();

        $table->timestamps();
    });
}