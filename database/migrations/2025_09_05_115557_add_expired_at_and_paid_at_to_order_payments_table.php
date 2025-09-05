<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_payments', function (Blueprint $table) {
            $table->timestamp('expired_at')
                ->nullable()
                ->after('json_callback');

            $table->timestamp('paid_at')
                ->nullable()
                ->after('expired_at');
        });
    }

    public function down(): void
    {
        Schema::table('order_payments', function (Blueprint $table) {
            $table->dropColumn(['expired_at', 'paid_at']);
        });
    }
};
