<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the description column exists before trying to add it
        if (!Schema::hasColumn('projects', 'description')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->text('description')->nullable()->after('title');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop the column if it exists
        if (Schema::hasColumn('projects', 'description')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
