<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('global_variables', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('type')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default global variables
        DB::table('global_variables')->insert([
            ['key' => 'payment_fee_type', 'type'=> 'string', 'value' => 'percent'],
            ['key' => 'payment_fee_percent', 'type'=> 'float',  'value' => '2'],
            ['key' => 'payment_fee_percent_min_value', 'type'=> 'float',  'value' => '2000'],
            ['key' => 'payment_fee_percent_max_value', 'type'=> 'float',  'value' => null],
            ['key' => 'payment_fee_fixed', 'type'=> 'float',  'value' => '2500'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_variables');
    }
};
