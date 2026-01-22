<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Psychologist;
use App\Models\Service;
use App\Models\Article;
use App\Models\User;
use App\Models\Faq;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Sample Psychologists
        Psychologist::create([
            'name' => 'Dr. Amara Sylvi ',
            'title' => 'M.Psi, Psikolog',
            'bio' => 'Psikolog klinis dengan pengalaman lebih dari 10 tahun menangani berbagai kasus kesehatan mental.',
            'specialization' => 'Psikologi Klinis',
            'education' => 'S2 Psikologi Klinis, Universitas Indonesia',
            'experience' => '10+ tahun',
            'email' => 'amara@psikologicenter.com',
            'phone' => '0895400200203',
            'is_active' => true,
        ]);

        Psychologist::create([
            'name' => 'Dr. Michael Chen',
            'title' => 'M.Psi',
            'bio' => 'Spesialis dalam psikologi anak dan remaja dengan pendekatan terapi kognitif behavioral.',
            'specialization' => 'Psikologi Anak dan Remaja',
            'education' => 'S2 Psikologi Pendidikan, UGM',
            'experience' => '8+ tahun',
            'email' => 'michael@psikologicenter.com',
            'phone' => '0813-4567-8901',
            'is_active' => true,
        ]);

        // Sample Services
        Service::create([
            'name' => 'Konseling Individual',
            'slug' => 'konseling-individual',
            'description' => 'Sesi konseling pribadi one-on-one dengan psikolog profesional untuk membahas masalah personal Anda.',
            'icon' => 'fas fa-user',
            'price' => 250000,
            'duration' => 60,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Terapi Keluarga',
            'slug' => 'terapi-keluarga',
            'description' => 'Terapi untuk mengatasi konflik keluarga dan meningkatkan komunikasi antar anggota keluarga.',
            'icon' => 'fas fa-users',
            'price' => 400000,
            'duration' => 90,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Konseling Pasangan',
            'slug' => 'konseling-pasangan',
            'description' => 'Membantu pasangan mengatasi masalah dalam hubungan dan membangun komunikasi yang lebih baik.',
            'icon' => 'fas fa-heart',
            'price' => 350000,
            'duration' => 90,
            'is_active' => true,
        ]);

        // Sample Article
        $user = User::first();
        if ($user) {
            Article::create([
                'user_id' => $user->id,
                'title' => '5 Cara Mengelola Stres di Tempat Kerja',
                'slug' => '5-cara-mengelola-stres-di-tempat-kerja',
                'excerpt' => 'Pelajari teknik efektif untuk mengurangi stres kerja dan meningkatkan produktivitas Anda.',
                'content' => 'Stres di tempat kerja adalah masalah umum yang dialami banyak orang. Berikut adalah 5 cara efektif untuk mengelola stres...',
                'category' => 'Kesehatan Mental',
                'is_published' => true,
                'published_at' => now(),
                'views' => 0,
            ]);
        }

        // Sample FAQ
        Faq::create([
            'question' => 'Apa itu psikolog?',
            'answer' => 'Psikolog adalah profesional kesehatan mental yang terlatih untuk membantu Anda mengatasi masalah emosional, mental, dan perilaku.',
            'category' => 'Umum',
            'order' => 1,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Berapa lama durasi satu sesi konseling?',
            'answer' => 'Durasi sesi konseling biasanya berkisar antara 50 hingga 90 menit, tergantung jenis layanan yang Anda pilih.',
            'category' => 'Layanan',
            'order' => 2,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Apakah informasi pribadi saya aman dan rahasia?',
            'answer' => 'Ya, kami menjamin kerahasiaan semua informasi pribadi Anda sesuai dengan kode etik psikologi profesional.',
            'category' => 'Keamanan',
            'order' => 3,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Bagaimana cara membuat janji temu?',
            'answer' => 'Anda dapat membuat janji temu melalui aplikasi kami, menghubungi admin, atau mengisi formulir booking di website.',
            'category' => 'Layanan',
            'order' => 4,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Apakah psikolog kami tersedia untuk konsultasi online?',
            'answer' => 'Ya, kami menyediakan layanan konsultasi online untuk kenyamanan Anda. Anda bisa memilih sesi online atau tatap muka.',
            'category' => 'Layanan',
            'order' => 5,
            'is_active' => true,
        ]);

        Faq::create([
            'question' => 'Berapa biaya untuk konseling individual?',
            'answer' => 'Biaya konseling individual adalah Rp 250.000 per sesi (60 menit). Harga dapat berubah sesuai kebijakan kami.',
            'category' => 'Harga',
            'order' => 6,
            'is_active' => true,
        ]);
    }
}