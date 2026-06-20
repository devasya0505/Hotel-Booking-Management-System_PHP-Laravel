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
        if (Schema::hasTable('bookings') && !Schema::hasColumn('bookings', 'country_code')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('country_code', 10)->after('email')->default('+1');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('bookings') && Schema::hasColumn('bookings', 'country_code')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('country_code');
            });
        }
    }
};
