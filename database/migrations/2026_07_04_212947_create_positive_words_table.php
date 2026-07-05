public function up(): void
{
    Schema::create('positive_words', function (Blueprint $table) {
        $table->id();
        $table->string('word')->unique();
        $table->timestamps();
    });
}