    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            
Schema::create('papers', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('type', 100);
    $table->year('year');
    $table->string('file_path');
    $table->unsignedInteger('cited')->default(0);
    $table->timestamps();
});

        }

        public function down(): void
        {
            Schema::dropIfExists('papers');
        }
    };
