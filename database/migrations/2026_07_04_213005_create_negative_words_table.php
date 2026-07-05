public function up(): void
{
    Schema::create('negative_words', function (Blueprint $table) {
        $table->id();
        $table->string('word')->unique();
        $table->timestamps();
    });
}