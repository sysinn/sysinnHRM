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
        Schema::create('performances', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('employee_id');
        $table->integer('rating')->comment('1-5 scale');
        $table->text('review')->nullable();
        $table->date('review_date')->default(DB::raw('CURRENT_DATE'));
        $table->string('reviewed_by')->nullable(); 
        $table->string('goals')->nullable();          // goals set for employee
        $table->string('achievements')->nullable();   // achievements
        $table->string('improvement_area')->nullable(); // where to improve
        $table->string('training_recommended')->nullable(); // suggested training
        $table->enum('status',['Excellent','Good','Average','Poor'])->default('Average'); // overall status
        $table->string('remarks')->nullable(); // additional comments or notes
        $table->timestamps();
        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};
