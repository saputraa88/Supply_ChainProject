public function up(): void
{
    Schema::create('risk_scores', function (Blueprint $table) {
        $table->id();

        $table->foreignId('country_id')
              ->constrained('countries')
              ->cascadeOnDelete();

        $table->decimal('weather_score', 5, 2)->default(0);
        $table->decimal('inflation_score', 5, 2)->default(0);
        $table->decimal('currency_score', 5, 2)->default(0);
        $table->decimal('news_score', 5, 2)->default(0);

        $table->decimal('total_score', 5, 2)->default(0);

        $table->enum('risk_level', [
            'Low',
            'Medium',
            'High'
        ])->default('Low');

        $table->timestamps();
    });
}