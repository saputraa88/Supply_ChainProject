public function up(): void
{
    Schema::create('news_caches', function (Blueprint $table) {
        $table->id();

        $table->foreignId('country_id')
              ->constrained('countries')
              ->cascadeOnDelete();

        $table->string('title');
        $table->text('description')->nullable();
        $table->string('url')->nullable();
        $table->string('sentiment')->nullable();
        $table->timestamp('published_at')->nullable();

        $table->timestamps();
    });
}