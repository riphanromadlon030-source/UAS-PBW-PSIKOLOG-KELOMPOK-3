<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First check if appointments table exists
        if (!Schema::hasTable('appointments')) {
            return;
        }

        // Get the exact ENUM definition
        try {
            $columns = DB::selectOne("
                SELECT COLUMN_TYPE
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = 'appointments'
                AND TABLE_SCHEMA = ?
                AND COLUMN_NAME = 'status'
            ", [DB::getDatabaseName()]);

            if ($columns) {
                $currentType = $columns->COLUMN_TYPE;
                // Check if 'in_progress' exists
                if (strpos($currentType, 'in_progress') === false) {
                    // Update the ENUM to include 'in_progress'
                    DB::statement(
                        "ALTER TABLE appointments MODIFY status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') DEFAULT 'pending' NOT NULL COLLATE utf8mb4_unicode_ci"
                    );
                }
            }
        } catch (\Exception $e) {
            // If we can't query INFORMATION_SCHEMA, just apply the fix
            DB::statement(
                "ALTER TABLE appointments MODIFY status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') DEFAULT 'pending' NOT NULL COLLATE utf8mb4_unicode_ci"
            );
        }
    }

    public function down(): void
    {
        // Revert to original enum values
        try {
            DB::statement(
                "ALTER TABLE appointments MODIFY status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending' NOT NULL COLLATE utf8mb4_unicode_ci"
            );
        } catch (\Exception $e) {
            // Silently fail on down
        }
    }
};
