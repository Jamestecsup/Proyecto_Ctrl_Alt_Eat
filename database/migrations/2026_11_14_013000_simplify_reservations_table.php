<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->renameColumn('qr_code', 'pickup_code');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->renameColumn('pickup_code', 'qr_code');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('status');
        });
    }
};
