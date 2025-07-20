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
            // Index for price filtering and sorting
            $table->index(['final_price', 'stock'], 'products_price_stock_index');
            
            // Index for shop filtering
            $table->index(['shop_id', 'stock'], 'products_shop_stock_index');
            
            // Index for sorting by creation date
            $table->index(['created_at', 'stock'], 'products_created_stock_index');
            
            // Index for name sorting
            $table->index(['name', 'stock'], 'products_name_stock_index');
            
            // Composite index for active products
            $table->index(['deleted_at', 'stock', 'final_price'], 'products_active_index');
        });

        Schema::table('category_product', function (Blueprint $table) {
            // Index for category filtering
            $table->index(['category_id', 'product_id'], 'category_product_filter_index');
        });

        Schema::table('shops', function (Blueprint $table) {
            // Index for open shops
            $table->index(['is_open', 'id'], 'shops_open_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_price_stock_index');
            $table->dropIndex('products_shop_stock_index');
            $table->dropIndex('products_created_stock_index');
            $table->dropIndex('products_name_stock_index');
            $table->dropIndex('products_active_index');
        });

        Schema::table('category_product', function (Blueprint $table) {
            $table->dropIndex('category_product_filter_index');
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->dropIndex('shops_open_index');
        });
    }
};
