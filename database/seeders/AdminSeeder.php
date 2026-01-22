<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@psikolog.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('Super Admin');

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@psikolog.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

        // Create Psychologist User
        $psychologist = User::create([
            'name' => 'Dr. Psikolog',
            'email' => 'psikolog@psikolog.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);
        $psychologist->assignRole('Psychologist');

        // Create Staff User
        $staff = User::create([
            'name' => 'Staff Admin',
            'email' => 'staff@psikolog.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);
        $staff->assignRole('Admin');
    }
}