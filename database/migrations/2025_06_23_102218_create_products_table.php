<?php

use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sku');
            $table->string('slug')->unique();
            $table->string('name');
            $table->foreignIdFor(Shop::class);
            $table->text('meta_description')->nullable();
            $table->text('long_description')->nullable();
            $table->json('tags')->nullable();
            $table->json('specification')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('final_price', 10, 2)->default(0);
            $table->boolean('has_variant')->default(false);
            $table->unsignedInteger('stock')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
