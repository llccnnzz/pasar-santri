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
        Schema::table('promotions', function (Blueprint $table) {
            // Change decimal precision for IDR currency (no decimal places needed)
            $table->decimal('discount_value', 12, 0)->change();
            $table->decimal('minimum_order_amount', 12, 0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            // Revert back to 2 decimal places
            $table->decimal('discount_value', 10, 2)->change();
            $table->decimal('minimum_order_amount', 10, 2)->change();
        });
    }
};
