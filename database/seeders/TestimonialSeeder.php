<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Rini Kusuma',
                'content' => 'Konsultasi dengan Dr. Budi sangat membantu saya mengatasi kecemasan. Saya merasa lebih tenang dan memiliki strategi yang tepat.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Hendra Wijaya',
                'content' => 'Terapi dengan Dr. Siti untuk keluarga saya sangat efektif. Komunikasi keluarga menjadi lebih baik.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Lia Santoso',
                'content' => 'Coaching karir dengan Dr. Ahmad sangat membantu saya menemukan arah karir yang tepat.',
                'rating' => 4,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Doni Pratama',
                'content' => 'Sangat puas dengan layanan. Psikolog sangat profesional dan memahami masalah saya.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Maya Sari',
                'content' => 'Workshop mindfulness sangat bermanfaat. Saya belajar teknik relaksasi yang efektif.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Rizal Pratama',
                'content' => 'Konseling anak dengan Dr. Siti membantu anak saya mengatasi masalah sekolah.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Nina Kurnia',
                'content' => 'Terapi trauma membantu saya pulih dari pengalaman buruk di masa lalu.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'content' => 'Coaching life skills memberikan saya keterampilan baru untuk menghadapi tantangan hidup.',
                'rating' => 4,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Sari Dewi',
                'content' => 'Konseling hubungan menyelamatkan pernikahan saya. Terima kasih atas bantuannya.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Budi Setiawan',
                'content' => 'Assessment psikologis memberikan wawasan yang mendalam tentang diri saya.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Lina Marlina',
                'content' => 'Konseling grief membantu saya melalui proses kehilangan dengan lebih baik.',
                'rating' => 5,
                'avatar' => null,
                'is_approved' => true,
            ],
            [
                'name' => 'Dedi Kusnandar',
                'content' => 'Layanan online sangat nyaman dan efektif. Tidak perlu datang ke kantor.',
                'rating' => 4,
                'avatar' => null,
                'is_approved' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
