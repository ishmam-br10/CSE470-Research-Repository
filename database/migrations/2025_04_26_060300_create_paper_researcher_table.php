    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            
Schema::create('paper_researcher', function (Blueprint $table) {
    $table->foreignId('paper_id')->constrained()->cascadeOnDelete();
    $table->foreignId('researcher_id')->constrained()->cascadeOnDelete();
    $table->primary(['paper_id','researcher_id']);
});

        }

        public function down(): void
        {
            Schema::dropIfExists('paper_researcher');
        }
    };
