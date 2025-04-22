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
        Schema::create('users', function (Blueprint $table) {
            $table->id('UserID'); // Primary key
            $table->string('Name');
            $table->string('Email')->unique()->index();
            $table->string('password');
            $table->enum('Role', ['student', 'teacher', 'admin']);
            $table->unsignedBigInteger('ClassID')->nullable(); // Foreign key to Classes
            $table->string('PIN', 4)->nullable(); // 4-digit PIN for students            
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            
            // Foreign key constraint
            // $table->foreign('ClassID')->references('ClassID')->on('classes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
