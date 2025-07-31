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
        Schema::create('kyc_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('nationality')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->string('phone');
            
            // Identity Document
            $table->enum('document_type', ['national_id', 'passport', 'driving_license']);
            $table->string('document_number');
            $table->date('document_expiry_date')->nullable();
            $table->string('document_issued_country');
            
            // File attachments (stored as JSON paths)
            $table->json('document_front_photo')->nullable(); // Front side of ID
            $table->json('document_back_photo')->nullable();  // Back side of ID (if applicable)
            $table->json('selfie_photo')->nullable();         // Selfie with ID
            $table->json('additional_documents')->nullable(); // Any additional docs
            
            // Application Status
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            
            // Additional metadata
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->boolean('privacy_accepted')->default(false);
            
            $table->timestamps();
            $table->softDeletes(); // For audit trail
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_applications');
    }
};
