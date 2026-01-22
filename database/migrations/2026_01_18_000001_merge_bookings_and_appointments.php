<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new columns to appointments table
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('jadwal_id')->nullable()->after('schedule_id')->constrained()->onDelete('cascade');
            $table->string('nama_lengkap')->nullable()->after('name');
            $table->string('telepon')->nullable()->after('phone');
            $table->text('keluhan')->nullable()->after('complaint');
            $table->text('catatan_admin')->nullable()->after('notes');
            $table->enum('booking_type', ['appointment', 'booking'])->default('appointment')->after('status');
        });

        // Migrate data from bookings to appointments
        DB::statement('INSERT INTO appointments (jadwal_id, user_id, nama_lengkap, email, telepon, keluhan, status, catatan_admin, booking_type, created_at, updated_at)
                      SELECT jadwal_id, user_id, nama_lengkap, email, telepon, keluhan, status, catatan_admin, "booking", created_at, updated_at FROM bookings');

        // Drop bookings table
        Schema::dropIfExists('bookings');
    }

    public function down(): void
    {
        // Recreate bookings table
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('telepon');
            $table->text('keluhan')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });

        // Remove merged columns
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['jadwal_id', 'nama_lengkap', 'telepon', 'keluhan', 'catatan_admin', 'booking_type']);
        });
    }
};
