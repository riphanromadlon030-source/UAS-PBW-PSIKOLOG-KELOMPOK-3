<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            // First check if the column exists and what its current ENUM is
            $columns = DB::select("SHOW COLUMNS FROM appointments WHERE Field='status'");
            
            if (!empty($columns)) {
                $current = $columns[0];
                
                // If in_progress is not already in the type, add it
                if (!str_contains($current->Type, "'in_progress'")) {
                    DB::statement(
                        "ALTER TABLE appointments MODIFY status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') NOT NULL DEFAULT 'pending' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
                    );
                }
            }
        } catch (\Exception $e) {
            // Log but don't fail
            \Log::warning('Failed to modify status ENUM: ' . $e->getMessage());
        }
    }

    public function down(): void
    {
        try {
            DB::statement(
                "ALTER TABLE appointments MODIFY status ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending'"
            );
        } catch (\Exception $e) {
            \Log::warning('Failed to revert status ENUM: ' . $e->getMessage());
        }
    }
};
