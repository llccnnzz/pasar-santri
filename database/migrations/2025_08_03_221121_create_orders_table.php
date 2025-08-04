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
            $table->unsignedBigInteger('user_id'); // bigint to match users table
            $table->uuid('shop_id'); // uuid to match shops table
            $table->string('invoice')->unique();
            $table->enum('status', [
                'pending',
                'confirmed', 
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'refunded'
            ])->default('pending');
            $table->json('order_details'); // contains items, quantities, prices, etc.
            $table->json('payment_detail'); // contains payment method, amount, etc.
            $table->text('cancellation_reason')->nullable();
            $table->string('shipment_ref_id')->nullable();
            $table->json('tracking_details')->nullable();
            $table->boolean('has_reviewed')->default(false);
            $table->boolean('has_settlement')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            
            // Indexes for performance
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
