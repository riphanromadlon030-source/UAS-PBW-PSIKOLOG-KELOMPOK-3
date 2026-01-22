<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminSeeder::class,
            PsychologistSeeder::class,
            PsychologistDataSeeder::class,
            ServiceSeeder::class,
            PsychologistServiceSeeder::class,
            ScheduleSeeder::class,
            ArticleSeeder::class,
            AppointmentSeeder::class,
            TestimonialSeeder::class,
            WebinarSeeder::class,
            JadwalSeeder::class,
            ClientSeeder::class,
            FaqSeeder::class,
            ContactSeeder::class,
            PsychologistAdminSeeder::class,
        ]);
    }
}
