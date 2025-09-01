<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('courier_code');
            $table->string('courier_name');
            $table->string('service_code');
            $table->string('service_name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['courier_code', 'service_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_methods');
    }
};
