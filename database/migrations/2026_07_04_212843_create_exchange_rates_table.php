public function up(): void
{
    Schema::create('exchange_rates', function (Blueprint $table) {
        $table->id();

        $table->foreignId('country_id')
              ->constrained('countries')
              ->cascadeOnDelete();

        $table->string('base_currency');
        $table->string('target_currency');
        $table->decimal('rate', 15, 4);

        $table->timestamps();
    });
}