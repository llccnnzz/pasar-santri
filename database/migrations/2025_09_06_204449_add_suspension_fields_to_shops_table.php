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
        Schema::table('shops', function (Blueprint $table) {
            $table->boolean('is_suspended')->default(false)->after('is_featured');
            $table->text('suspended_reason')->nullable()->after('is_suspended');
            $table->timestamp('suspended_at')->nullable()->after('suspended_reason');
            $table->unsignedBigInteger('suspended_by')->nullable()->after('suspended_at');
            
            // Add foreign key constraint for who suspended the shop
            $table->foreign('suspended_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropForeign(['suspended_by']);
            $table->dropColumn(['is_suspended', 'suspended_reason', 'suspended_at', 'suspended_by']);
        });
    }
};
