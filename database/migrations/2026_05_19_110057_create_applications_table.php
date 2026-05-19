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
        Schema::create('applications', function (Blueprint $table) {
            // Primary Key
            $table->id();
            
            // Foreign Key to users table
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Application Basic Information
            $table->string('company_name'); // VARCHAR(255) NOT NULL
            $table->string('job_title');    // VARCHAR(255) NOT NULL
            $table->text('job_url')->nullable(); // TEXT NULL - optional job posting URL
            
            // Workflow Fields
            $table->string('status', 50);   // VARCHAR(50) NOT NULL
            $table->string('priority', 50); // VARCHAR(50) NOT NULL
            
            // Additional Information
            $table->text('notes')->nullable(); // TEXT NULL - free-form notes
            $table->date('application_date');  // DATE NOT NULL
            
            // Timestamps (created_at, updated_at)
            $table->timestamps();
            
            // Soft Deletes (deleted_at) - for archiving functionality
            $table->softDeletes();
            
            // Indexes for performance
            $table->index('status');         // Fast filtering by status (US9)
            $table->index('priority');       // Fast filtering by priority (US9)
            $table->index('deleted_at');     // Fast active/archived separation
            // Note: user_id is automatically indexed by foreignId()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};