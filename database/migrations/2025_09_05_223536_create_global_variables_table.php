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

        DB::table('global_variables')->insert([
            ['key' => 'banner_promotion_headline_primary', 'type'=> 'json', 'value' => '["\/assets\/imgs\/slider\/slider-3.png","\/assets\/imgs\/slider\/slider-4.png"]'],
            ['key' => 'banner_promotion_headline_secondary', 'type'=> 'string',  'value' => '/assets/imgs/banner/banner-11.png'],
            ['key' => 'banner_promotion_headline_child_1', 'type'=> 'string',  'value' => '/assets/imgs/banner/banner-1.png'],
            ['key' => 'banner_promotion_headline_child_2', 'type'=> 'string',  'value' => '/assets/imgs/banner/banner-2.png'],
            ['key' => 'banner_promotion_headline_child_3', 'type'=> 'string',  'value' => '/assets/imgs/banner/banner-3.png'],
            ['key' => 'banner_promotion_daily_best_seller', 'type'=> 'string',  'value' => '/assets/imgs/banner/banner-4.png'],
            ['key' => 'banner_promotion_footline', 'type'=> 'string',  'value' => '/assets/imgs/banner/banner-10.png'],
            ['key' => 'banner_promotion_login', 'type'=> 'string',  'value' => '/assets/imgs/page/login-1.png'],
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
