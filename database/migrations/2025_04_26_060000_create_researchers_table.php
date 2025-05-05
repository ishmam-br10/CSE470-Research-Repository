    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            
Schema::create('researchers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->string('department');
    $table->string('contact')->nullable();
    $table->string('avatar_path')->nullable();
    $table->timestamps();
});

        }

        public function down(): void
        {
            Schema::dropIfExists('researchers');
        }
    };
