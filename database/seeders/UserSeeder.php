<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Psychologist;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@psikologicenter.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Psychologist Account
        $psychologistUser = User::create([
            'name' => 'Dr. Jane Smith',
            'email' => 'psychologist@psikologicenter.com',
            'password' => Hash::make('password'),
            'role' => 'psychologist',
            'email_verified_at' => now(),
        ]);

        // Create psychologist profile
        Psychologist::create([
            'user_id' => $psychologistUser->id,
            'name' => 'Dr. Jane Smith',
            'email' => 'psychologist@psikologicenter.com',
            'phone' => '081234567890',
            'specialization' => 'Clinical Psychology',
            'experience_years' => 5,
            'education' => 'PhD in Psychology',
            'bio' => 'Experienced clinical psychologist specializing in anxiety and depression.',
            'status' => 'active',
        ]);

        // Regular User Account
        User::create([
            'name' => 'John Doe',
            'email' => 'user@psikologicenter.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}