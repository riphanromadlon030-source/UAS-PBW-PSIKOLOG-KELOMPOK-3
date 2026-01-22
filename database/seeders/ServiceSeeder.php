<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Konsultasi Individu',
                'slug' => Str::slug('Konsultasi Individu'),
                'description' => 'Layanan konsultasi psikologi untuk mengatasi masalah pribadi, stres, kecemasan, dan depresi.',
                'icon' => null,
                'image' => null,
                'price' => 300000,
                'duration' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Terapi Keluarga',
                'slug' => Str::slug('Terapi Keluarga'),
                'description' => 'Layanan terapi untuk menyelesaikan masalah keluarga dan meningkatkan komunikasi antar anggota keluarga.',
                'icon' => null,
                'image' => null,
                'price' => 500000,
                'duration' => 90,
                'is_active' => true,
            ],
            [
                'name' => 'Coaching Karir',
                'slug' => Str::slug('Coaching Karir'),
                'description' => 'Konsultasi untuk pengembangan karir dan menemukan potensi diri dalam pekerjaan.',
                'icon' => null,
                'image' => null,
                'price' => 400000,
                'duration' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Terapi Trauma',
                'slug' => Str::slug('Terapi Trauma'),
                'description' => 'Layanan khusus untuk mengatasi trauma dan PTSD dengan pendekatan evidence-based.',
                'icon' => null,
                'image' => null,
                'price' => 600000,
                'duration' => 90,
                'is_active' => true,
            ],
            [
                'name' => 'Konseling Hubungan',
                'slug' => Str::slug('Konseling Hubungan'),
                'description' => 'Membantu pasangan mengatasi masalah hubungan dan meningkatkan intimasi emosional.',
                'icon' => null,
                'image' => null,
                'price' => 450000,
                'duration' => 75,
                'is_active' => true,
            ],
            [
                'name' => 'Konseling Anak dan Remaja',
                'slug' => Str::slug('Konseling Anak dan Remaja'),
                'description' => 'Layanan konseling khusus untuk anak dan remaja menghadapi masalah perkembangan dan perilaku.',
                'icon' => null,
                'image' => null,
                'price' => 350000,
                'duration' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Terapi CBT',
                'slug' => Str::slug('Terapi CBT'),
                'description' => 'Cognitive Behavioral Therapy untuk mengubah pola pikir dan perilaku negatif.',
                'icon' => null,
                'image' => null,
                'price' => 400000,
                'duration' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Konseling Online',
                'slug' => Str::slug('Konseling Online'),
                'description' => 'Layanan konseling melalui platform digital untuk kenyamanan klien.',
                'icon' => null,
                'image' => null,
                'price' => 250000,
                'duration' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Assessment Psikologis',
                'slug' => Str::slug('Assessment Psikologis'),
                'description' => 'Penilaian psikologis komprehensif untuk diagnosis dan rekomendasi.',
                'icon' => null,
                'image' => null,
                'price' => 750000,
                'duration' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'Workshop Mindfulness',
                'slug' => Str::slug('Workshop Mindfulness'),
                'description' => 'Workshop kelompok tentang teknik mindfulness untuk relaksasi dan kesadaran.',
                'icon' => null,
                'image' => null,
                'price' => 200000,
                'duration' => 90,
                'is_active' => true,
            ],
            [
                'name' => 'Konseling Grief',
                'slug' => Str::slug('Konseling Grief'),
                'description' => 'Dukungan untuk mengatasi proses grieving dan kehilangan.',
                'icon' => null,
                'image' => null,
                'price' => 350000,
                'duration' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Coaching Life Skills',
                'slug' => Str::slug('Coaching Life Skills'),
                'description' => 'Pelatihan keterampilan hidup untuk meningkatkan produktivitas dan kesejahteraan.',
                'icon' => null,
                'image' => null,
                'price' => 300000,
                'duration' => 60,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
