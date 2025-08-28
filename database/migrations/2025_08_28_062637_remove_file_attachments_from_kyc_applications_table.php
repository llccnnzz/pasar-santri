<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kyc_applications', function (Blueprint $table) {
            $table->dropColumn([
                'document_front_photo',
                'document_back_photo',
                'selfie_photo',
                'additional_documents',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('kyc_applications', function (Blueprint $table) {
            $table->json('document_front_photo')->nullable();
            $table->json('document_back_photo')->nullable();
            $table->json('selfie_photo')->nullable();
            $table->json('additional_documents')->nullable();
        });
    }
};
