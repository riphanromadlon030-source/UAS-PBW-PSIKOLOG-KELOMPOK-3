<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Berapa harga konsultasi dengan psikolog?',
                'answer' => 'Harga konsultasi bervariasi tergantung jenis layanan. Untuk konsultasi individu berkisar Rp 300.000 - Rp 600.000 per sesi.',
                'order' => 1,
            ],
            [
                'question' => 'Apakah saya perlu appointment terlebih dahulu?',
                'answer' => 'Ya, kami menyarankan untuk membuat appointment terlebih dahulu untuk memastikan psikolog tersedia. Anda bisa booking melalui website kami.',
                'order' => 2,
            ],
            [
                'question' => 'Berapa lama satu sesi konsultasi?',
                'answer' => 'Satu sesi konsultasi biasanya berlangsung 60 menit untuk konsultasi individu, dan 90 menit untuk sesi keluarga atau terapi khusus.',
                'order' => 3,
            ],
            [
                'question' => 'Apakah data saya terjaga kerahasiaan?',
                'answer' => 'Tentu, kami menjaga kerahasiaan klien sesuai dengan kode etik psikolog Indonesia. Semua informasi Anda dijaga dengan ketat.',
                'order' => 4,
            ],
            [
                'question' => 'Apakah tersedia layanan konsultasi online?',
                'answer' => 'Ya, kami menyediakan layanan konsultasi online melalui video call untuk kenyamanan Anda.',
                'order' => 5,
            ],
            [
                'question' => 'Bagaimana cara pembayaran?',
                'answer' => 'Kami menerima pembayaran melalui transfer bank, e-wallet, dan kartu kredit. Pembayaran dapat dilakukan sebelum atau sesudah sesi konsultasi.',
                'order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
