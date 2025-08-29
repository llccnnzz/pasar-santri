<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->text('description')->change();

            $table->string('province')->after('address')->nullable();
            $table->string('city')->after('address')->nullable();
            $table->string('subdistrict')->after('address')->nullable();
            $table->string('village')->after('address')->nullable();
            $table->string('postal_code')->after('address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('description')->change();

            $table->dropColumn(['province', 'city', 'subdistrict', 'village', 'postal_code']);
        });
    }
};
