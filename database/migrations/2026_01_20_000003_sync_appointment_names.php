<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Copy 'name' to 'nama_lengkap' for records where nama_lengkap is null or empty
        DB::statement("UPDATE appointments 
                      SET nama_lengkap = name 
                      WHERE nama_lengkap IS NULL OR nama_lengkap = ''");
    }

    public function down(): void
    {
        // No down action needed - we're just syncing data
    }
};
