    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            
Schema::create('borrows', function (Blueprint $table) {
    $table->id();
    $table->foreignId('paper_id')->constrained()->cascadeOnDelete();
    $table->foreignId('borrower_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamp('borrowed_at')->useCurrent();
    $table->timestamp('due_at')->nullable();
    $table->timestamp('returned_at')->nullable();
    $table->enum('status',['borrowed','returned'])->default('borrowed');
    $table->timestamps();
});

        }

        public function down(): void
        {
            Schema::dropIfExists('borrows');
        }
    };
