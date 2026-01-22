<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convert old status values to new ones
        DB::statement("UPDATE appointments SET status = 'in_progress' WHERE status = 'in-progress' OR status = 'in_progress'");
        // Optionally convert 'confirmed' to 'in_progress' if needed
        // DB::statement("UPDATE appointments SET status = 'in_progress' WHERE status = 'confirmed'");
    }

    public function down(): void
    {
        // No specific down action needed for data migration
    }
};
