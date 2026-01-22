<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Psychologist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PsychologistSeeder extends Seeder
{
    public function run(): void
    {
        Psychologist::create([
            'name' => 'Dr. Budi Santoso',
            'title' => 'M.Psi',
            'specialization' => 'Psikologi Klinis',
            'education' => 'S1 Psikologi Universitas Indonesia, S2 Psikologi Klinis Universitas Gadjah Mada',
            'experience' => '10 tahun pengalaman di bidang psikologi klinis, spesialis gangguan kecemasan dan depresi',
            'phone' => '+6281234567890',
            'email' => 'budi.santoso@psikolog.com',
            'bio' => 'Dr. Budi Santoso adalah psikolog klinis berpengalaman dengan spesialisasi dalam terapi kognitif perilaku. Beliau telah membantu ratusan klien mengatasi berbagai masalah kesehatan mental seperti kecemasan, depresi, dan trauma. Pendekatan terapi yang digunakan adalah evidence-based dengan fokus pada pemulihan dan pengembangan potensi individu.',
            'is_active' => true,
        ]);

        Psychologist::create([
            'name' => 'Dr. Siti Nurhaliza',
            'title' => 'M.Psi, Psikolog',
            'specialization' => 'Psikologi Anak dan Remaja',
            'education' => 'S1 Psikologi Universitas Padjadjaran, S2 Psikologi Anak Universitas Indonesia',
            'experience' => '8 tahun pengalaman di bidang psikologi anak dan remaja, ahli dalam pengembangan anak dan masalah perilaku',
            'phone' => '+6289876543210',
            'email' => 'siti.nurhaliza@psikolog.com',
            'bio' => 'Dr. Siti Nurhaliza memiliki keahlian khusus dalam psikologi anak dan remaja. Beliau berfokus pada pemahaman perkembangan anak, masalah perilaku, dan dukungan bagi orang tua dalam mendidik anak. Dengan pendekatan yang ramah dan empatik, Dr. Siti telah membantu banyak keluarga menciptakan lingkungan yang sehat untuk perkembangan anak.',
            'is_active' => true,
        ]);

        Psychologist::create([
            'name' => 'Dr. Ahmad Wijaya',
            'title' => 'M.Psi',
            'specialization' => 'Psikologi Industri dan Organisasi',
            'education' => 'S1 Psikologi Universitas Airlangga, S2 Psikologi Industri Universitas Gadjah Mada',
            'experience' => '12 tahun pengalaman di bidang psikologi industri, konsultan kesehatan mental di workplace',
            'phone' => '+6281122334455',
            'email' => 'ahmad.wijaya@psikolog.com',
            'bio' => 'Dr. Ahmad Wijaya adalah ahli psikologi industri dan organisasi yang berpengalaman dalam konsultasi kesehatan mental di lingkungan kerja. Beliau membantu perusahaan dalam mengelola stres karyawan, meningkatkan produktivitas, dan menciptakan budaya kerja yang sehat. Pendekatannya yang praktis dan berbasis data telah membantu banyak organisasi meningkatkan kesejahteraan karyawan.',
            'is_active' => true,
        ]);

        Psychologist::create([
            'name' => 'Dr. Maya Sari',
            'title' => 'M.Psi, Psikolog',
            'specialization' => 'Psikologi Keluarga dan Perkawinan',
            'education' => 'S1 Psikologi Universitas Diponegoro, S2 Psikologi Keluarga Universitas Indonesia',
            'experience' => '9 tahun pengalaman di bidang konseling keluarga dan perkawinan',
            'phone' => '+6285566677788',
            'email' => 'maya.sari@psikolog.com',
            'bio' => 'Dr. Maya Sari spesialis dalam psikologi keluarga dan perkawinan. Beliau membantu pasangan dan keluarga mengatasi konflik, membangun komunikasi yang sehat, dan memperkuat ikatan keluarga. Dengan pendekatan yang holistik, Dr. Maya mempertimbangkan aspek emosional, sosial, dan spiritual dalam setiap sesi konseling.',
            'is_active' => true,
        ]);

        Psychologist::create([
            'name' => 'Dr. Rizal Pratama',
            'title' => 'M.Psi',
            'specialization' => 'Psikologi Pendidikan',
            'education' => 'S1 Psikologi Universitas Negeri Jakarta, S2 Psikologi Pendidikan Universitas Pendidikan Indonesia',
            'experience' => '7 tahun pengalaman di bidang psikologi pendidikan dan bimbingan konseling siswa',
            'phone' => '+6287788990011',
            'email' => 'rizal.pratama@psikolog.com',
            'bio' => 'Dr. Rizal Pratama adalah psikolog pendidikan yang fokus pada pengembangan potensi siswa dan masalah pembelajaran. Beliau membantu siswa mengatasi kesulitan belajar, masalah motivasi, dan tantangan emosional di lingkungan sekolah. Dengan pendekatan yang mendukung, Dr. Rizal telah membantu banyak siswa mencapai potensi maksimal mereka.',
            'is_active' => true,
        ]);
    }
}
