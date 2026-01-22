<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Pertanyaan tentang layanan',
            'message' => 'Saya ingin tahu lebih lanjut tentang layanan konseling yang tersedia.',
        ]);

        \App\Models\Contact::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'subject' => 'Jadwal konsultasi',
            'message' => 'Kapan jadwal konsultasi tersedia untuk minggu depan?',
            'admin_reply' => 'Jadwal konsultasi tersedia setiap hari Senin-Jumat pukul 09.00-17.00 WIB.',
            'replied_at' => now(),
        ]);

        \App\Models\Contact::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@example.com',
            'subject' => 'Informasi biaya',
            'message' => 'Berapa biaya untuk sesi konseling 1 jam?',
        ]);
    }
}
