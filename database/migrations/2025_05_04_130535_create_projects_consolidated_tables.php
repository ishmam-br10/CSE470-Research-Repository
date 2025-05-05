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
        // Create projects table first
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('ongoing'); // ongoing, completed, cancelled
            $table->foreignId('researcher_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Then create project_researcher pivot table
        Schema::create('project_researcher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('researcher_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('collaborator'); // owner, collaborator
            $table->timestamps();
        });

        // Finally create project_applications table
        Schema::create('project_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('motivation'); // Why they want to join
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
            
            // Ensure a user can only apply once to a project
            $table->unique(['project_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_applications');
        Schema::dropIfExists('project_researcher');
        Schema::dropIfExists('projects');
    }
};
