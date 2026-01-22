<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing tests to avoid duplicates
        \App\Models\Test::where('title', 'Tes Kepribadian Big Five')->delete();
        \App\Models\Test::where('title', 'Tes Tingkat Stres')->delete();

        \App\Models\Test::create([
            'title' => 'Tes Kepribadian Big Five',
            'description' => 'Tes sederhana untuk mengukur lima dimensi kepribadian utama: Keterbukaan, Kesadaran, Ekstraversi, Keramahan, dan Neurotisisme.',
            'questions' => [
                    [
                        'question' => 'Saya suka mencoba hal-hal baru dan berbeda.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'openness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya mudah bergaul dengan orang lain.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'extraversion',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya selalu menyelesaikan tugas-tugas saya tepat waktu.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'conscientiousness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya peduli dengan perasaan orang lain.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'agreeableness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya sering merasa cemas atau khawatir.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'neuroticism',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya suka berimajinasi dan berkreasi.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'openness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya lebih suka menghabiskan waktu sendirian daripada bersama orang banyak.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'extraversion',
                    'reverse' => true
                ],
                [
                    'question' => 'Saya selalu merencanakan segala sesuatu dengan baik.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'conscientiousness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya mudah memaafkan kesalahan orang lain.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'agreeableness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya mudah tersinggung atau marah.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'neuroticism',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya tertarik dengan seni dan budaya.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'openness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya suka menjadi pusat perhatian.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'extraversion',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya selalu menepati janji saya.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'conscientiousness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya suka membantu orang lain.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'agreeableness',
                    'reverse' => false
                ],
                [
                    'question' => 'Saya suka rutinitas dan hal-hal yang sudah familiar.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'openness',
                    'reverse' => true
                ],
                [
                    'question' => 'Saya lebih suka diam dan tidak banyak bicara.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'extraversion',
                    'reverse' => true
                ],
                [
                    'question' => 'Saya sering menunda-nunda pekerjaan.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'conscientiousness',
                    'reverse' => true
                ],
                [
                    'question' => 'Saya suka berkompetisi dan menang dari orang lain.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'agreeableness',
                    'reverse' => true
                ],
                [
                    'question' => 'Saya jarang merasa khawatir tentang apa pun.',
                    'options' => ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'],
                    'dimension' => 'neuroticism',
                    'reverse' => true
                ]
            ]
        ]);

        \App\Models\Test::create([
            'title' => 'Tes Tingkat Stres',
            'description' => 'Tes untuk mengukur tingkat stres yang Anda alami dalam kehidupan sehari-hari.',
            'questions' => [
                    [
                        'question' => 'Saya merasa sulit untuk rileks.',
                    'options' => ['Selalu', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak Pernah'],
                    'dimension' => 'stress'
                ],
                [
                    'question' => 'Saya merasa gelisah atau cemas.',
                    'options' => ['Selalu', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak Pernah'],
                    'dimension' => 'stress'
                ],
                [
                    'question' => 'Saya merasa lelah meskipun sudah cukup istirahat.',
                    'options' => ['Selalu', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak Pernah'],
                    'dimension' => 'stress'
                ],
                [
                    'question' => 'Saya kesulitan berkonsentrasi.',
                    'options' => ['Selalu', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak Pernah'],
                    'dimension' => 'stress'
                ],
                [
                    'question' => 'Saya mudah marah atau tersinggung.',
                    'options' => ['Selalu', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak Pernah'],
                    'dimension' => 'stress'
                ],
                [
                    'question' => 'Saya mengalami masalah tidur.',
                    'options' => ['Selalu', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak Pernah'],
                    'dimension' => 'stress'
                ],
                [
                    'question' => 'Saya kehilangan minat pada hobi atau aktivitas yang saya sukai.',
                    'options' => ['Selalu', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak Pernah'],
                    'dimension' => 'stress'
                ],
                [
                    'question' => 'Saya merasa tidak berharga atau bersalah.',
                    'options' => ['Selalu', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak Pernah'],
                    'dimension' => 'stress'
                ]
            ]
        ]);
    }
}
