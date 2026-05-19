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
        Schema::create('interviews', function (Blueprint $table) {
            // Primary Key
            $table->id();
            
            // Foreign Key to applications table
            $table->foreignId('application_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Interview Details
            $table->string('type', 100); // VARCHAR(100) NOT NULL
            
            // Scheduling Information (separated for easier querying)
            $table->date('scheduled_date');  // DATE NOT NULL
            $table->time('scheduled_time');  // TIME NOT NULL
            
            // Optional Fields
            $table->text('preparation_notes')->nullable(); // TEXT NULL
            $table->string('result', 50)->nullable();      // VARCHAR(50) NULL
            
            // Timestamps (created_at, updated_at)
            $table->timestamps();
            
            // Indexes for performance
            $table->index('scheduled_date'); // Chronological sorting, upcoming interviews
            // Note: application_id automatically indexed by foreignId()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};