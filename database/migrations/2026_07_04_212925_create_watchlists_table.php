public function up(): void
{
    Schema::create('watchlists', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('country_id')
              ->constrained('countries')
              ->cascadeOnDelete();

        $table->timestamps();
    });
}