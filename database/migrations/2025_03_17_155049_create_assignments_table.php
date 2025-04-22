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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id('AssignmentID'); // Primary key
            $table->string('Title');
            $table->text('Description');
            $table->string('FilePath')->nullable(); // Path to the assignment file
            $table->dateTime('DueDate');
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
        Schema::dropIfExists('assignments');
    }
};
