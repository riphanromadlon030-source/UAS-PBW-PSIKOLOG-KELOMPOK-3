<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $jadwals = [
            [
                'psychologist_id' => 1,
                'judul' => 'Group Konseling - Manajemen Stress',
                'deskripsi' => 'Sesi grup untuk membahas manajemen stress dengan peserta yang menghadapi masalah serupa.',
                'tanggal_waktu' => Carbon::now()->addDays(3)->setTime(10, 0),
                'lokasi' => 'Ruang Konseling A',
                'kapasitas' => 10,
                'is_available' => true,
            ],
            [
                'psychologist_id' => 2,
                'judul' => 'Workshop Komunikasi Keluarga',
                'deskripsi' => 'Workshop interaktif tentang komunikasi efektif dalam keluarga.',
                'tanggal_waktu' => Carbon::now()->addDays(4)->setTime(14, 0),
                'lokasi' => 'Ruang Workshop',
                'kapasitas' => 20,
                'is_available' => true,
            ],
            [
                'psychologist_id' => 3,
                'judul' => 'Sesi Sharing Pengalaman',
                'deskripsi' => 'Pertemuan informal untuk sharing pengalaman dan saling mendukung.',
                'tanggal_waktu' => Carbon::now()->addDays(2)->setTime(17, 0),
                'lokasi' => 'Ruang Konseling B',
                'kapasitas' => 8,
                'is_available' => true,
            ],
            [
                'psychologist_id' => 4,
                'judul' => 'Konseling Pra Nikah',
                'deskripsi' => 'Sesi konseling untuk pasangan yang akan menikah.',
                'tanggal_waktu' => Carbon::now()->addDays(5)->setTime(16, 0),
                'lokasi' => 'Ruang Konseling C',
                'kapasitas' => 2,
                'is_available' => true,
            ],
            [
                'psychologist_id' => 5,
                'judul' => 'Workshop Motivasi Belajar',
                'deskripsi' => 'Workshop untuk siswa dan orang tua tentang motivasi belajar.',
                'tanggal_waktu' => Carbon::now()->addDays(6)->setTime(9, 0),
                'lokasi' => 'Ruang Workshop',
                'kapasitas' => 15,
                'is_available' => true,
            ],
            [
                'psychologist_id' => 1,
                'judul' => 'Group Konseling - Kecemasan Sosial',
                'deskripsi' => 'Sesi grup untuk mengatasi kecemasan sosial.',
                'tanggal_waktu' => Carbon::now()->addDays(7)->setTime(15, 0),
                'lokasi' => 'Ruang Konseling A',
                'kapasitas' => 12,
                'is_available' => true,
            ],
            [
                'psychologist_id' => 2,
                'judul' => 'Workshop Parenting',
                'deskripsi' => 'Workshop untuk orang tua tentang pola asuh yang efektif.',
                'tanggal_waktu' => Carbon::now()->addDays(8)->setTime(10, 0),
                'lokasi' => 'Ruang Workshop',
                'kapasitas' => 25,
                'is_available' => true,
            ],
            [
                'psychologist_id' => 3,
                'judul' => 'Sesi Konseling Karir',
                'deskripsi' => 'Konseling individu untuk pengembangan karir.',
                'tanggal_waktu' => Carbon::now()->addDays(9)->setTime(13, 0),
                'lokasi' => 'Ruang Konseling B',
                'kapasitas' => 1,
                'is_available' => true,
            ],
        ];

        foreach ($jadwals as $jadwal) {
            Jadwal::create($jadwal);
        }
    }
}
