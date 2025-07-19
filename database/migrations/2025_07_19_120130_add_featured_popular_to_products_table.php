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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('stock');
            $table->boolean('is_popular')->default(false)->after('is_featured');
            
            // Add indexes for performance
            $table->index(['is_featured', 'created_at']);
            $table->index(['is_popular', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_featured', 'created_at']);
            $table->dropIndex(['is_popular', 'created_at']);
            $table->dropColumn(['is_featured', 'is_popular']);
        });
    }
};
