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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('order_id')->constrained('orders')->onDelete('cascade');
            $table->unsignedBigInteger('payment_method_id')->nullable()->comment('Reference to payment method if applicable');
            $table->string('channel')->comment('Payment gateway: xendit, midtrans, bank_transfer, etc');
            $table->string('reference_id')->nullable()->comment('Payment gateway reference/transaction ID');
            $table->string('status')->default('pending')->comment('pending, processing, success, failed, cancelled, expired');
            $table->decimal('value', 15, 2)->comment('Payment amount');
            $table->decimal('payment_fee', 15, 2)->default(0)->comment('Payment gateway fee');
            $table->json('json_callback')->nullable()->comment('Complete callback data from payment gateway');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['order_id', 'status']);
            $table->index(['channel', 'status']);
            $table->index('reference_id');
            $table->index(['status', 'created_at']);

            // Ensure only one successful payment per order
            $table->unique(['order_id', 'status'], 'unique_successful_payment')
                  ->where('status', 'success');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
