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
        Schema::create('exams', function (Blueprint $table) {
            $table->id('ExamID'); // Primary key
            $table->string('Title');
            $table->text('Description');
            $table->dateTime('Date');
            $table->string('Location');
            $table->unsignedBigInteger('TeacherID'); // Foreign key to Users
            $table->unsignedBigInteger('ClassID'); // Foreign key to Classes
            $table->timestamps(); // CreatedAt and UpdatedAt

            // Foreign key constraints
            $table->foreign('TeacherID')->references('UserID')->on('users')->onDelete('cascade');
            $table->foreign('ClassID')->references('ClassID')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
