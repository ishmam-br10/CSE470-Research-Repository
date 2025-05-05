d_fix_migration_order.php
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
        // First, drop the problematic table if it exists
        Schema::dropIfExists('project_researcher');
        
        // Make sure we have a projects table
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('status')->default('ongoing');
                $table->foreignId('researcher_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
        
        // Now recreate the project_researcher table with proper foreign keys
        Schema::create('project_researcher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('researcher_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('collaborator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_researcher');
        Schema::dropIfExists('projects');
    }
};
