<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Add status column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'status')) {
                $table->enum('status', ['pending', 'replied', 'resolved'])->default('pending')->after('is_read');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
