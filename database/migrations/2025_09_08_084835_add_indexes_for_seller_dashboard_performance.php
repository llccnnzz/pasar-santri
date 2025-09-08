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
        Schema::table('orders', function (Blueprint $table) {
            // Composite index for shop_id + created_at (for date range queries)
            $table->index(['shop_id', 'created_at'], 'idx_orders_shop_created');
            
            // Composite index for shop_id + status (for status filtering)
            $table->index(['shop_id', 'status'], 'idx_orders_shop_status');
            
            // Composite index for shop_id + status + created_at (for complex queries)
            $table->index(['shop_id', 'status', 'created_at'], 'idx_orders_shop_status_created');
        });

        Schema::table('products', function (Blueprint $table) {
            // Composite index for shop_id + status (for active products count)
            $table->index(['shop_id', 'status'], 'idx_products_shop_status');
            
            // Composite index for shop_id + stock (for out of stock count)
            $table->index(['shop_id', 'stock'], 'idx_products_shop_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_shop_created');
            $table->dropIndex('idx_orders_shop_status');
            $table->dropIndex('idx_orders_shop_status_created');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_shop_status');
            $table->dropIndex('idx_products_shop_stock');
        });
    }
};
