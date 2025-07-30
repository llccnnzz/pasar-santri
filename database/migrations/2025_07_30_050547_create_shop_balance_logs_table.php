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
        Schema::create('shop_balance_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['in', 'out'])->default('in');
            $table->decimal('amount', 15, 2);
            $table->json('details')->nullable();
            $table->foreignIdFor(App\Models\ShopBank::class)->nullable()->constrained()->onDelete('set null');
            $table->string('reference')->nullable();
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_balance_logs');
    }
};
