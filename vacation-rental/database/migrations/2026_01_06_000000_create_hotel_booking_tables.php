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
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('hotels')) {
            Schema::create('hotels', function (Blueprint $table) {
                $table->id();
                $table->string('name', 40);
                $table->string('image');
                $table->text('description');
                $table->string('location', 40);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('apartments')) {
            Schema::create('apartments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('image');
                $table->unsignedInteger('max_persons');
                $table->string('size');
                $table->string('view');
                $table->unsignedInteger('num_beds');
                $table->decimal('price', 10, 2);
                $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('country_code', 10)->default('+1');
                $table->string('phone_number');
                $table->date('check_in');
                $table->date('check_out');
                $table->unsignedInteger('days');
                $table->decimal('price', 10, 2);
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('room_name');
                $table->string('hotel_name');
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('apartments');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('admins');
    }
};
