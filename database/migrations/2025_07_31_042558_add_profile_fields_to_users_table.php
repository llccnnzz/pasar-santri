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
        Schema::table('users', function (Blueprint $table) {
            // Profile fields
            $table->string('profile_photo')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('profile_photo');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->text('bio')->nullable()->after('gender');
            
            // Withdrawal PIN and security
            $table->string('withdrawal_pin')->nullable()->after('bio');
            $table->timestamp('withdrawal_pin_verified_at')->nullable()->after('withdrawal_pin');
            $table->timestamp('pin_last_changed_at')->nullable()->after('withdrawal_pin_verified_at');
            
            // Security tracking
            $table->timestamp('password_changed_at')->nullable()->after('pin_last_changed_at');
            $table->integer('login_attempts')->default(0)->after('password_changed_at');
            $table->timestamp('last_login_at')->nullable()->after('login_attempts');
            
            // Notification preferences (JSON)
            $table->json('notification_preferences')->nullable()->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'date_of_birth', 
                'gender',
                'bio',
                'withdrawal_pin',
                'withdrawal_pin_verified_at',
                'pin_last_changed_at',
                'login_attempts',
                'last_login_at',
                'notification_preferences'
            ]);
        });
    }
};
