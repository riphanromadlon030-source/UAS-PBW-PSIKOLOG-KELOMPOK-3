<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions
        $permissions = [
            'view dashboard',
            'manage users',
            'manage psychologist',
            'manage articles',
            'manage schedules',
            'manage appointments',
            'manage testimonials',
            'manage services',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo([
            'view dashboard',
            'manage psychologist',
            'manage articles',
            'manage schedules',
            'manage appointments',
            'manage testimonials',
            'manage services',
        ]);

        $psychologist = Role::firstOrCreate(['name' => 'Psychologist']);
        $psychologist->givePermissionTo([
            'view dashboard',
            'manage schedules',
            'manage appointments',
        ]);

        $counselor = Role::firstOrCreate(['name' => 'Counselor']);
        $counselor->givePermissionTo([
            'view dashboard',
            'manage schedules',
            'manage appointments',
        ]);

        $user = Role::firstOrCreate(['name' => 'User']);

        $staff = Role::firstOrCreate(['name' => 'Staff']);
        $staff->givePermissionTo([
            'view dashboard',
            'manage appointments',
        ]);

        // Buat User Super Admin
        $superAdminUser = User::updateOrCreate(
            ['email' => 'admin@psikologi.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdminUser->assignRole('Super Admin');

        // Buat User Biasa
        $regularUser = User::updateOrCreate(
            ['email' => 'user@psikologi.com'],
            [
                'name' => 'User Test',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $regularUser->assignRole('User');

        // Buat User Psychologist
        $psychologistUser = User::updateOrCreate(
            ['email' => 'psychologist@psikologi.com'],
            [
                'name' => 'Dr. Psychologist',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $psychologistUser->assignRole('Psychologist');

        // Buat User Counselor
        $counselorUser = User::updateOrCreate(
            ['email' => 'counselor@psikologi.com'],
            [
                'name' => 'Counselor Test',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $counselorUser->assignRole('Counselor');
    }
}