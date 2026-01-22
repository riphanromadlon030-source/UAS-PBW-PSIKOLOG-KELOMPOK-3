<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixAppointmentStatus extends Command
{
    protected $signature = 'fix:appointment-status';
    protected $description = 'Fix appointment status ENUM to include in_progress';

    public function handle()
    {
        try {
            // Check if appointments table exists
            $this->info('Checking appointments table...');
            
            // Get current ENUM definition
            $result = DB::selectOne(
                "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                 WHERE TABLE_NAME = 'appointments' 
                 AND TABLE_SCHEMA = ? 
                 AND COLUMN_NAME = 'status'",
                [DB::getDatabaseName()]
            );

            if (!$result) {
                $this->error('Appointments table or status column not found!');
                return 1;
            }

            $this->info('Current status type: ' . $result->COLUMN_TYPE);

            // Check if 'in_progress' already exists
            if (strpos($result->COLUMN_TYPE, 'in_progress') !== false) {
                $this->info('✓ in_progress already exists in ENUM');
                return 0;
            }

            // Update the ENUM
            $this->info('Updating status ENUM...');
            DB::statement(
                "ALTER TABLE appointments MODIFY status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') DEFAULT 'pending' NOT NULL COLLATE utf8mb4_unicode_ci"
            );

            // Verify the fix
            $result = DB::selectOne(
                "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                 WHERE TABLE_NAME = 'appointments' 
                 AND TABLE_SCHEMA = ? 
                 AND COLUMN_NAME = 'status'",
                [DB::getDatabaseName()]
            );

            $this->info('Updated status type: ' . $result->COLUMN_TYPE);
            $this->info('✓ Status ENUM fixed successfully!');
            return 0;

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
