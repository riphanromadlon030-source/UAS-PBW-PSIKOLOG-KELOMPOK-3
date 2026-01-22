<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        return view('public.tests.index', compact('tests'));
    }

    public function show($id)
    {
        $test = Test::findOrFail($id);
        return view('public.tests.show', compact('test'));
    }

    public function submit(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        $answers = $request->input('answers');

        // Validate that answers exist and all questions are answered
        if (!$answers || !is_array($answers)) {
            return redirect()->back()->with('error', 'Silakan jawab semua pertanyaan.');
        }

        // Check if all questions have answers
        $totalQuestions = count($test->questions);
        if (count($answers) !== $totalQuestions) {
            return redirect()->back()->with('error', 'Silakan jawab semua pertanyaan.');
        }

        // Check for empty answers
        foreach ($answers as $answer) {
            if (empty($answer)) {
                return redirect()->back()->with('error', 'Silakan jawab semua pertanyaan.');
            }
        }

        try {
            $result = $this->calculateResult($test, $answers);
            return view('public.tests.result', compact('test', 'result'));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Test calculation error: ' . $e->getMessage(), [
                'test_id' => $id,
                'answers' => $answers
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan dalam memproses hasil tes. Silakan coba lagi.');
        }
    }

    private function calculateResult($test, $answers)
    {
        if ($test->title === 'Tes Kepribadian Big Five') {
            return $this->calculateBigFiveResult($test, $answers);
        } elseif ($test->title === 'Tes Tingkat Stres') {
            return $this->calculateStressResult($answers);
        }

        return 'Hasil tes Anda sedang diproses. Terima kasih telah mengikuti tes ini.';
    }

    private function calculateBigFiveResult($test, $answers)
    {
        $scores = [
            'openness' => 0,
            'extraversion' => 0,
            'conscientiousness' => 0,
            'agreeableness' => 0,
            'neuroticism' => 0
        ];

        $questionCount = [
            'openness' => 0,
            'extraversion' => 0,
            'conscientiousness' => 0,
            'agreeableness' => 0,
            'neuroticism' => 0
        ];

        foreach ($answers as $index => $answer) {
            $question = $test->questions[$index] ?? null;
            if ($question && isset($question['dimension'])) {
                $dimension = $question['dimension'];
                $score = $this->convertAnswerToScore($answer, $question);
                $scores[$dimension] += $score;
                $questionCount[$dimension]++;
            }
        }

        // Calculate averages
        $result = "**HASIL TES KEPRIBADIAN BIG FIVE**\n\n";
        $result .= "Berikut adalah skor kepribadian Anda berdasarkan lima dimensi utama:\n\n";

        $dimensions = [
            'openness' => ['name' => 'Keterbukaan (Openness)', 'desc' => 'Kreativitas, imajinasi, dan keterbukaan terhadap pengalaman baru'],
            'extraversion' => ['name' => 'Ekstraversi (Extraversion)', 'desc' => 'Energi sosial, antusiasme, dan kecenderungan untuk berinteraksi dengan orang lain'],
            'conscientiousness' => ['name' => 'Kesadaran (Conscientiousness)', 'desc' => 'Kedisiplinan, ketekunan, dan kemampuan merencanakan'],
            'agreeableness' => ['name' => 'Keramahan (Agreeableness)', 'desc' => 'Kebaikan hati, empati, dan kemampuan bekerja sama'],
            'neuroticism' => ['name' => 'Neurotisisme (Neuroticism)', 'desc' => 'Kecenderungan mengalami emosi negatif dan ketidakstabilan emosional']
        ];

        foreach ($dimensions as $key => $info) {
            if ($questionCount[$key] > 0) {
                $average = round($scores[$key] / $questionCount[$key], 1);
                $level = $this->getScoreLevel($average);
                $interpretation = $this->getDimensionInterpretation($key, $average);

                $result .= "**{$info['name']}: {$average}/5 ({$level})**\n";
                $result .= "{$info['desc']}\n";
                $result .= "*{$interpretation}*\n\n";
            }
        }

        $result .= "**Interpretasi Umum:**\n";
        $result .= "Hasil tes ini memberikan gambaran umum tentang kepribadian Anda. ";
        $result .= "Untuk pemahaman yang lebih mendalam, disarankan berkonsultasi dengan psikolog profesional.\n\n";

        $result .= "**Rekomendasi:**\n";
        $result .= "• Gunakan hasil ini untuk meningkatkan kesadaran diri\n";
        $result .= "• Fokus pada pengembangan aspek kepribadian yang ingin ditingkatkan\n";
        $result .= "• Jika mengalami kesulitan emosional, segera konsultasikan dengan ahli";

        return $result;
    }

    private function calculateStressResult($answers)
    {
        $totalScore = 0;
        $maxScore = count($answers) * 4; // Max score per question is 4

        foreach ($answers as $answer) {
            $score = $this->convertStressAnswerToScore($answer);
            $totalScore += $score;
        }

        $percentage = round(($totalScore / $maxScore) * 100, 1);
        $level = $this->getStressLevel($percentage);

        $result = "**HASIL TES TINGKAT STRES**\n\n";
        $result .= "**Skor Anda: {$totalScore}/{$maxScore} ({$percentage}%)**\n\n";
        $result .= "**Tingkat Stres: {$level['level']}**\n\n";
        $result .= "**Interpretasi:**\n{$level['description']}\n\n";

        if ($percentage >= 70) {
            $result .= "**Rekomendasi Darurat:**\n";
            $result .= "• Segera konsultasikan dengan psikolog atau psikiater\n";
            $result .= "• Cari dukungan dari orang terdekat\n";
            $result .= "• Lakukan teknik relaksasi segera\n";
        } elseif ($percentage >= 50) {
            $result .= "**Rekomendasi:**\n";
            $result .= "• Kurangi beban kerja jika memungkinkan\n";
            $result .= "• Lakukan olahraga teratur\n";
            $result .= "• Praktikkan teknik meditasi atau mindfulness\n";
            $result .= "• Pastikan waktu istirahat yang cukup\n";
        } else {
            $result .= "**Rekomendasi:**\n";
            $result .= "• Pertahankan gaya hidup sehat\n";
            $result .= "• Lakukan aktivitas yang Anda nikmati\n";
            $result .= "• Jaga keseimbangan antara kerja dan istirahat\n";
        }

        $result .= "\n**Penting:** Hasil tes ini bukan diagnosis medis. Jika gejala berlanjut, konsultasikan dengan tenaga profesional kesehatan mental.";

        return $result;
    }

    private function convertAnswerToScore($answer, $question = null)
    {
        $scores = [
            'Sangat Setuju' => 5,
            'Setuju' => 4,
            'Netral' => 3,
            'Tidak Setuju' => 2,
            'Sangat Tidak Setuju' => 1
        ];

        $score = $scores[$answer] ?? 3;

        // Handle reverse-coded questions
        if ($question && isset($question['reverse']) && $question['reverse']) {
            $score = 6 - $score; // Reverse the score (5->1, 4->2, 3->3, 2->4, 1->5)
        }

        return $score;
    }

    private function convertStressAnswerToScore($answer)
    {
        $scores = [
            'Selalu' => 4,
            'Sering' => 3,
            'Kadang-kadang' => 2,
            'Jarang' => 1,
            'Tidak Pernah' => 0
        ];

        return $scores[$answer] ?? 0;
    }

    private function getScoreLevel($score)
    {
        if ($score >= 4.5) return 'Sangat Tinggi';
        if ($score >= 3.5) return 'Tinggi';
        if ($score >= 2.5) return 'Sedang';
        if ($score >= 1.5) return 'Rendah';
        return 'Sangat Rendah';
    }

    private function getDimensionInterpretation($dimension, $score)
    {
        $interpretations = [
            'openness' => [
                'low' => 'Anda cenderung lebih suka rutinitas dan hal-hal yang familiar. Anda mungkin lebih nyaman dengan pendekatan tradisional dan kurang tertarik pada perubahan atau ide-ide baru.',
                'medium' => 'Anda memiliki keseimbangan antara kreativitas dan preferensi terhadap hal-hal yang familiar. Anda terbuka terhadap pengalaman baru dalam batas tertentu.',
                'high' => 'Anda sangat terbuka terhadap pengalaman baru, kreativitas, dan ide-ide inovatif. Anda suka mengeksplorasi hal-hal baru dan berpikir di luar kotak.'
            ],
            'extraversion' => [
                'low' => 'Anda cenderung lebih introvert dan suka menghabiskan waktu sendirian. Anda mendapatkan energi dari waktu pribadi dan refleksi internal.',
                'medium' => 'Anda memiliki keseimbangan antara sifat ekstrovert dan introvert. Anda dapat menikmati interaksi sosial maupun waktu sendiri.',
                'high' => 'Anda sangat ekstrovert dan mendapatkan energi dari interaksi sosial. Anda suka menjadi pusat perhatian dan mudah bergaul dengan orang lain.'
            ],
            'conscientiousness' => [
                'low' => 'Anda cenderung lebih spontan dan kurang terorganisir. Anda mungkin lebih suka pendekatan yang fleksibel daripada perencanaan ketat.',
                'medium' => 'Anda cukup terorganisir dan bertanggung jawab, namun masih memiliki fleksibilitas dalam pendekatan Anda.',
                'high' => 'Anda sangat terorganisir, disiplin, dan bertanggung jawab. Anda suka merencanakan segala sesuatu dengan baik dan menepati komitmen.'
            ],
            'agreeableness' => [
                'low' => 'Anda cenderung lebih kompetitif dan kurang peduli dengan perasaan orang lain. Anda mungkin lebih fokus pada hasil daripada harmoni interpersonal.',
                'medium' => 'Anda cukup peduli dengan orang lain namun juga tahu kapan harus bersikap tegas. Anda memiliki keseimbangan antara empati dan ketegasan.',
                'high' => 'Anda sangat peduli dengan perasaan orang lain, empati, dan suka membantu. Anda lebih memilih kerja sama daripada kompetisi.'
            ],
            'neuroticism' => [
                'low' => 'Anda sangat stabil emosional dan jarang mengalami kecemasan atau emosi negatif. Anda cenderung tenang dan mudah beradaptasi.',
                'medium' => 'Anda cukup stabil emosional namun kadang mengalami kecemasan atau emosi negatif dalam situasi tertentu.',
                'high' => 'Anda cenderung mengalami emosi negatif seperti kecemasan, kemarahan, atau kesedihan. Anda mungkin lebih sensitif terhadap stres.'
            ]
        ];

        if ($score >= 4.0) {
            return $interpretations[$dimension]['high'];
        } elseif ($score >= 2.5) {
            return $interpretations[$dimension]['medium'];
        } else {
            return $interpretations[$dimension]['low'];
        }
    }

    private function getStressLevel($percentage)
    {
        if ($percentage >= 70) {
            return [
                'level' => 'STRES BERAT',
                'description' => 'Anda mengalami tingkat stres yang sangat tinggi. Gejala stres yang Anda alami cukup intens dan mungkin mempengaruhi kesehatan fisik dan mental Anda. Disarankan untuk segera mencari bantuan profesional.'
            ];
        } elseif ($percentage >= 50) {
            return [
                'level' => 'STRES SEDANG',
                'description' => 'Anda mengalami tingkat stres yang cukup tinggi. Beberapa gejala stres mulai muncul dan mempengaruhi aktivitas sehari-hari. Perlu perhatian untuk mengelola stres ini.'
            ];
        } elseif ($percentage >= 30) {
            return [
                'level' => 'STRES RINGAN',
                'description' => 'Anda mengalami tingkat stres yang ringan. Kadang-kadang Anda merasa stres namun masih dapat mengelola dengan baik. Tetap jaga keseimbangan hidup Anda.'
            ];
        } else {
            return [
                'level' => 'STRES MINIMAL',
                'description' => 'Anda mengalami tingkat stres yang minimal. Anda mampu mengelola stres dengan baik dan menjaga keseimbangan emosional. Pertahankan pola hidup sehat ini.'
            ];
        }
    }
}
