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
        Schema::create('documents', function (Blueprint $table) {
            // Primary Key
            $table->id();
            
            // Foreign Key to applications table
            $table->foreignId('application_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // File Metadata
            $table->string('file_name');        // VARCHAR(255) NOT NULL - original filename
            $table->string('file_path', 500);   // VARCHAR(500) NOT NULL - storage path
            $table->string('file_type', 50);    // VARCHAR(50) NOT NULL - MIME type
            $table->unsignedInteger('file_size'); // INT UNSIGNED NOT NULL - size in bytes
            
            // Timestamps (created_at, updated_at)
            $table->timestamps();
            
            // Index for performance
            // Note: application_id automatically indexed by foreignId()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};