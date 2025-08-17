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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('order_details')->comment('Complete order information including items, quantities, prices');
            $table->json('payment_detail')->comment('Payment amount, currency, breakdown details');
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending')->comment('pending, confirmed, processing, shipped, delivered, cancelled, refunded');
            $table->string('invoice')->unique()->comment('Format: INV/YYYY-MM-DD/XXXX');
            $table->foreignUuid('shop_id')->constrained('shops')->onDelete('cascade');
            $table->string('cancellation_reason')->nullable()->comment('Reason for order cancellation');
            $table->uuid('shipment_ref_id')->nullable()->comment('Reference to shipping provider');
            $table->json('tracking_details')->nullable()->comment('Tracking information from shipping provider');
            $table->boolean('has_reviewed')->default(false)->comment('Has customer reviewed the order');
            $table->boolean('has_settlement')->default(false)->comment('Has payment been settled to seller');
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['shop_id', 'status']);
            $table->index(['status', 'created_at']);
            $table->index('invoice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
