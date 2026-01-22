<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $appointments = [
            [
                'user_id' => null,
                'psychologist_id' => 1,
                'schedule_id' => 1,
                'name' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'phone' => '081234567890',
                'appointment_date' => Carbon::now()->addDay(),
                'complaint' => 'Merasa cemas dengan pekerjaan',
                'status' => 'pending',
                'notes' => 'Klien pertama kali',
            ],
            [
                'user_id' => null,
                'psychologist_id' => 2,
                'schedule_id' => 3,
                'name' => 'Sinta Dewi',
                'email' => 'sinta@example.com',
                'phone' => '082345678901',
                'appointment_date' => Carbon::now()->addDays(2),
                'complaint' => 'Ingin konsultasi tentang anak',
                'status' => 'confirmed',
                'notes' => 'Sudah konfirmasi',
            ],
            [
                'user_id' => null,
                'psychologist_id' => 3,
                'schedule_id' => 5,
                'name' => 'Budi Santoso',
                'email' => 'budi2@example.com',
                'phone' => '083456789012',
                'appointment_date' => Carbon::now()->addDays(3),
                'complaint' => 'Masalah hubungan keluarga',
                'status' => 'pending',
                'notes' => 'Keluarga ada 4 orang',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}
