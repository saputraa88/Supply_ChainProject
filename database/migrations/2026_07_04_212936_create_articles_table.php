public function up(): void
{
    Schema::create('articles', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->string('title');
        $table->text('content');
        $table->string('image')->nullable();

        $table->timestamps();
    });
}