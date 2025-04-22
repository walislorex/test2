<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id('ClassID'); // Primary key
            $table->string('Name');
            $table->unsignedBigInteger('TeacherID'); // Foreign key
            $table->json('Subjects')->nullable(); // JSON column for subjects
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('TeacherID')
                  ->references('UserID')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};