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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('NotificationID'); // Primary key
            $table->unsignedBigInteger('UserID'); // Foreign key to Users
            $table->text('Message');
            $table->boolean('ReadStatus')->default(false); // Default to false (unread)
            $table->timestamps(); // CreatedAt and UpdatedAt

            // Foreign key constraint
            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
