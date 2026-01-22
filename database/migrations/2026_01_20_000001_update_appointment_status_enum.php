<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update appointments table status enum to include 'in_progress'
        // Using raw SQL for MySQL compatibility
        DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending'");
    }
};
