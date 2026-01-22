<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check current ENUM and update if needed
        try {
            // Get the server version to handle both MySQL 5.7 and 8.0
            $result = DB::select(DB::raw("SHOW COLUMNS FROM appointments WHERE Field = 'status'"));
            
            if (!empty($result)) {
                $currentType = $result[0]->Type ?? '';
                
                // Only update if 'in_progress' is not already in the ENUM
                if (stripos($currentType, 'in_progress') === false) {
                    DB::statement(
                        "ALTER TABLE appointments MODIFY status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') DEFAULT 'pending' COLLATE utf8mb4_unicode_ci"
                    );
                }
            }
        } catch (\Exception $e) {
            // If check fails, proceed with alter anyway
            DB::statement(
                "ALTER TABLE appointments MODIFY status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') DEFAULT 'pending' COLLATE utf8mb4_unicode_ci"
            );
        }
    }

    public function down(): void
    {
        // Revert back to original enum values
        try {
            DB::statement(
                "ALTER TABLE appointments MODIFY status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending' COLLATE utf8mb4_unicode_ci"
            );
        } catch (\Exception $e) {
            // Silently fail on down
        }
    }
};
