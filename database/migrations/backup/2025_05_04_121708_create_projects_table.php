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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('ongoing'); // ongoing, completed, cancelled
            $table->foreignId('researcher_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Create pivot table for researchers collaborating on projects
        Schema::create('project_researcher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('researcher_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('collaborator'); // owner, collaborator
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