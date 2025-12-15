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
        Schema::create('grades', function (Blueprint $table) {
            $table->id('grade_id');
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers', 'teacher_id')->onDelete('cascade');
            $table->string('academic_period'); // Q1, Q2, Q3, Q4
            $table->enum('cognitive_skills', ['excellent', 'good', 'satisfactory', 'needs_improvement'])->default('satisfactory');
            $table->enum('motor_skills', ['excellent', 'good', 'satisfactory', 'needs_improvement'])->default('satisfactory');
            $table->enum('social_skills', ['excellent', 'good', 'satisfactory', 'needs_improvement'])->default('satisfactory');
            $table->enum('emotional_dev', ['excellent', 'good', 'satisfactory', 'needs_improvement'])->default('satisfactory');
            $table->enum('behavior', ['excellent', 'good', 'satisfactory', 'needs_improvement'])->default('satisfactory');
            $table->text('teacher_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
