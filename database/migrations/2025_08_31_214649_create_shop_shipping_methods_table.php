<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shop_shipping_methods', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('shop_id');
            $table->uuid('shipping_method_id');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->unique(['shop_id', 'shipping_method_id']);

            $table->foreign('shop_id')
                ->references('id')->on('shops')
                ->onDelete('cascade');

            $table->foreign('shipping_method_id')
                ->references('id')->on('shipping_methods')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shop_shipping_methods');
    }
};
