<?php

namespace Database\Seeders;

use App\Models\Webinar;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WebinarSeeder extends Seeder
{
    public function run(): void
    {
        $webinars = [
            [
                'title' => 'Mengatasi Stres di Tempat Kerja',
                'description' => 'Webinar interaktif tentang strategi mengatasi stres di tempat kerja dengan pembicara dari praktisi berpengalaman.',
                'starts_at' => Carbon::now()->addDays(10)->setTime(14, 0),
                'link' => 'https://zoom.us/meeting/example1',
                'is_published' => true,
            ],
            [
                'title' => 'Psikologi Anak di Era Digital',
                'description' => 'Memahami perkembangan anak di era digital dan cara orang tua menghadapi tantangan ini.',
                'starts_at' => Carbon::now()->addDays(15)->setTime(19, 0),
                'link' => 'https://zoom.us/meeting/example2',
                'is_published' => true,
            ],
            [
                'title' => 'Teknik Mindfulness untuk Kesejahteraan',
                'description' => 'Workshop praktis tentang mindfulness dan meditasi untuk meningkatkan kesejahteraan mental.',
                'starts_at' => Carbon::now()->addDays(20)->setTime(10, 0),
                'link' => 'https://zoom.us/meeting/example3',
                'is_published' => true,
            ],
            [
                'title' => 'Komunikasi Efektif dalam Hubungan',
                'description' => 'Webinar tentang teknik komunikasi yang sehat dalam hubungan romantis dan keluarga.',
                'starts_at' => Carbon::now()->addDays(25)->setTime(16, 0),
                'link' => 'https://zoom.us/meeting/example4',
                'is_published' => true,
            ],
            [
                'title' => 'Motivasi dan Produktivitas',
                'description' => 'Strategi untuk meningkatkan motivasi diri dan produktivitas dalam kehidupan sehari-hari.',
                'starts_at' => Carbon::now()->addDays(30)->setTime(11, 0),
                'link' => 'https://zoom.us/meeting/example5',
                'is_published' => true,
            ],
            [
                'title' => 'Mengatasi Kecemasan Sosial',
                'description' => 'Panduan praktis untuk mengelola dan mengatasi kecemasan sosial dalam berbagai situasi.',
                'starts_at' => Carbon::now()->addDays(35)->setTime(18, 0),
                'link' => 'https://zoom.us/meeting/example6',
                'is_published' => true,
            ],
        ];

        foreach ($webinars as $webinar) {
            Webinar::create($webinar);
        }
    }
}
