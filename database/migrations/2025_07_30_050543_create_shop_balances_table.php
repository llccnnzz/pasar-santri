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
        Schema::create('shop_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Shop::class)->constrained()->onDelete('cascade');
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('pending_in', 15, 2)->default(0.00);
            $table->decimal('pending_out', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_balances');
    }
};
