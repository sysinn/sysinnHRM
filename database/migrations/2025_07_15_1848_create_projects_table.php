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
            $table->string('name');                       // Project name
            $table->string('client_name')->nullable();
            $table->text('description')->nullable();      // Description (optional)
            $table->enum('status', ['pending', 'ongoing', 'completed', 'on-hold'])->default('pending'); // Status
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
             $table->integer('progress')->default(0);   
            $table->date('start_date')->nullable();       // Optional
            $table->date('end_date')->nullable();         // Optional
            $table->unsignedBigInteger('assigned_to')->nullable(); // User who owns or leads the project
            $table->timestamps();
            // Foreign key constraint (assuming 'users' table exists)
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
