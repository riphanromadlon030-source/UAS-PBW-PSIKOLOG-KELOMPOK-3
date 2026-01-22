<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'user_id' => 2,
                'title' => 'Cara Mengatasi Kecemasan dalam Kehidupan Sehari-hari',
                'slug' => Str::slug('Cara Mengatasi Kecemasan dalam Kehidupan Sehari-hari'),
                'excerpt' => 'Kecemasan adalah perasaan yang umum dialami oleh banyak orang.',
                'content' => 'Kecemasan adalah perasaan yang umum dialami oleh banyak orang. Artikel ini membahas teknik-teknik praktis untuk mengatasi kecemasan melalui mindfulness, breathing exercises, dan cognitive behavioral therapy.',
                'featured_image' => null,
                'category' => 'Kesehatan Mental',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'user_id' => 3,
                'title' => 'Pentingnya Kesehatan Mental di Era Digital',
                'slug' => Str::slug('Pentingnya Kesehatan Mental di Era Digital'),
                'excerpt' => 'Di era digital ini, kesehatan mental menjadi semakin penting.',
                'content' => 'Di era digital ini, kesehatan mental menjadi semakin penting. Paparan media sosial, informasi berlebihan, dan tekanan digital dapat mempengaruhi kesejahteraan mental kita. Artikel ini mengeksplorasi cara menjaga keseimbangan digital.',
                'featured_image' => null,
                'category' => 'Digital Wellness',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Tidur Berkualitas: Kunci Kesehatan Mental',
                'slug' => Str::slug('Tidur Berkualitas: Kunci Kesehatan Mental'),
                'excerpt' => 'Kualitas tidur memiliki dampak signifikan pada kesehatan mental kita.',
                'content' => 'Kualitas tidur memiliki dampak signifikan pada kesehatan mental kita. Artikel ini membahas hubungan antara tidur dan kesehatan mental, serta tips untuk meningkatkan kualitas tidur Anda.',
                'featured_image' => null,
                'category' => 'Sleep & Wellness',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Membangun Hubungan yang Sehat',
                'slug' => Str::slug('Membangun Hubungan yang Sehat'),
                'excerpt' => 'Hubungan yang sehat adalah fondasi dari kesejahteraan emosional.',
                'content' => 'Hubungan yang sehat adalah fondasi dari kesejahteraan emosional. Artikel ini membahas komunikasi efektif, boundary setting, dan cara mengatasi konflik dalam hubungan.',
                'featured_image' => null,
                'category' => 'Hubungan',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'user_id' => 3,
                'title' => 'Stress di Tempat Kerja dan Cara Mengatasinya',
                'slug' => Str::slug('Stress di Tempat Kerja dan Cara Mengatasinya'),
                'excerpt' => 'Stres kerja adalah hal yang umum terjadi.',
                'content' => 'Stres kerja adalah hal yang umum terjadi. Artikel ini memberikan strategi untuk mengelola stress, meningkatkan produktivitas, dan menciptakan lingkungan kerja yang lebih sehat.',
                'featured_image' => null,
                'category' => 'Work Stress',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'Teknik Meditasi untuk Pemula',
                'slug' => Str::slug('Teknik Meditasi untuk Pemula'),
                'excerpt' => 'Meditasi adalah alat yang efektif untuk menenangkan pikiran.',
                'content' => 'Meditasi adalah alat yang efektif untuk menenangkan pikiran dan mengurangi stres. Artikel ini memandu pemula melalui teknik meditasi dasar yang mudah dipraktikkan.',
                'featured_image' => null,
                'category' => 'Mindfulness',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'user_id' => 5,
                'title' => 'Mengembangkan Kecerdasan Emosional Anak',
                'slug' => Str::slug('Mengembangkan Kecerdasan Emosional Anak'),
                'excerpt' => 'Kecerdasan emosional penting untuk perkembangan anak.',
                'content' => 'Kecerdasan emosional penting untuk perkembangan anak. Artikel ini memberikan tips praktis bagi orang tua untuk membantu anak mengembangkan EQ mereka.',
                'featured_image' => null,
                'category' => 'Parenting',
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
