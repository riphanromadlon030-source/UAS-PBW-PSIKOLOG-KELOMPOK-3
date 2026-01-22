<?php

namespace Database\Seeders;

use App\Models\Psychologist;
use Illuminate\Database\Seeder;

class PsychologistDataSeeder extends Seeder
{
    public function run(): void
    {
        $psychologists = [
            [
                'name' => 'Dr. Budi Santoso',
                'title' => 'Dr.',
                'bio' => 'Spesialis dalam menangani kecemasan dan depresi dengan pengalaman lebih dari 10 tahun.',
                'specialization' => 'Psikologi Klinis',
                'education' => 'S2 Psikologi Klinis - Universitas Indonesia',
                'experience' => '10 tahun praktik psikologi',
                'photo' => null,
                'email' => 'budi@psikolog.com',
                'phone' => '081234567890',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Siti Nurhaliza',
                'title' => 'Dr.',
                'bio' => 'Ahli dalam konseling keluarga dan perkembangan anak.',
                'specialization' => 'Psikologi Anak dan Remaja',
                'education' => 'S2 Psikologi Perkembangan - Universitas Gadjah Mada',
                'experience' => '8 tahun praktik psikologi anak',
                'photo' => null,
                'email' => 'siti@psikolog.com',
                'phone' => '082345678901',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Ahmad Wijaya',
                'title' => 'Dr.',
                'bio' => 'Berpengalaman dalam psikologi organisasi dan manajemen stress di tempat kerja.',
                'specialization' => 'Psikologi Industri dan Organisasi',
                'education' => 'S2 Psikologi Industri - Universitas Airlangga',
                'experience' => '12 tahun praktik psikologi industri',
                'photo' => null,
                'email' => 'ahmad@psikolog.com',
                'phone' => '083456789012',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Maya Sari',
                'title' => 'Dr.',
                'bio' => 'Spesialis dalam konseling keluarga dan masalah perkawinan.',
                'specialization' => 'Psikologi Keluarga dan Perkawinan',
                'education' => 'S2 Psikologi Keluarga - Universitas Padjadjaran',
                'experience' => '9 tahun praktik konseling keluarga',
                'photo' => null,
                'email' => 'maya@psikolog.com',
                'phone' => '084567890123',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Rudi Hartono',
                'title' => 'Dr.',
                'bio' => 'Ahli dalam psikologi pendidikan dan pembelajaran anak.',
                'specialization' => 'Psikologi Pendidikan',
                'education' => 'S2 Psikologi Pendidikan - Universitas Negeri Jakarta',
                'experience' => '11 tahun praktik psikologi pendidikan',
                'photo' => null,
                'email' => 'rudi@psikolog.com',
                'phone' => '085678901234',
                'is_active' => true,
            ],
        ];

        foreach ($psychologists as $psychologist) {
            Psychologist::create($psychologist);
        }
    }
}
