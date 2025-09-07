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
        Schema::create('product_ads', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->enum('category', ['flash_sale', 'hot_promo', 'big_discount', 'new_product', 'less_than_10k']);
            $table->integer('sort_order')->default(0)->nullable(); // For manual ordering in hot_promo
            $table->datetime('valid_until')->nullable(); // For flash_sale expiration
            $table->boolean('is_active')->default(true);
            $table->enum('submission_type', ['manual', 'auto_suggest'])->default('manual');
            $table->text('admin_notes')->nullable(); // Admin notes for manual submissions
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            // Indexes for better performance
            $table->index(['category', 'is_active']);
            $table->index(['category', 'sort_order']);
            $table->index('valid_until');
            $table->unique(['product_id', 'category']); // Prevent duplicate product in same category
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ads');
    }
};
