<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ensure the appointments table has the correct ENUM values for status
        if (Schema::hasTable('appointments')) {
            try {
                // Use raw SQL to set the ENUM with all necessary values
                DB::statement(
                    "ALTER TABLE appointments 
                     MODIFY COLUMN status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') 
                     DEFAULT 'pending' 
                     NOT NULL 
                     COLLATE utf8mb4_unicode_ci"
                );
            } catch (\Exception $e) {
                // Log but don't fail - the ENUM might already be correct
                \Log::warning('Failed to modify appointments status column: ' . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally revert to original ENUM
        if (Schema::hasTable('appointments')) {
            try {
                DB::statement(
                    "ALTER TABLE appointments 
                     MODIFY COLUMN status ENUM('pending', 'confirmed', 'completed', 'cancelled') 
                     DEFAULT 'pending' 
                     NOT NULL 
                     COLLATE utf8mb4_unicode_ci"
                );
            } catch (\Exception $e) {
                // Silent fail
            }
        }
    }
};
