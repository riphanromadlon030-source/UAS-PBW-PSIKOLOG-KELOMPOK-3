<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Psychologist;
use App\Models\Service;
use App\Models\Article;
use App\Models\Testimonial;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\Webinar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CompleteDataSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'view dashboard',
            'manage users',
            'manage psychologists',
            'manage articles',
            'manage schedules',
            'manage appointments',
            'manage testimonials',
            'manage services',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions([
            'view dashboard',
            'manage psychologists',
            'manage articles',
            'manage schedules',
            'manage appointments',
            'manage testimonials',
            'manage services',
        ]);

        $staff = Role::firstOrCreate(['name' => 'Staff']);
        $staff->syncPermissions([
            'view dashboard',
            'manage appointments',
            'manage schedules',
        ]);

        $user = Role::firstOrCreate(['name' => 'User']);

        // Create Super Admin User
        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@psikologi.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdminUser->syncRoles('Super Admin');

        // Create Regular User
        $regularUser = User::firstOrCreate(
            ['email' => 'user@psikologi.com'],
            [
                'name' => 'User Test',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $regularUser->syncRoles('User');

        // Create Psychologists
        $psychologists = [
            [
                'name' => 'Dr. Sarah Johnson',
                'title' => 'M.Psi, Psikolog',
                'bio' => 'Psikolog klinis dengan pengalaman lebih dari 10 tahun dalam menangani berbagai kasus kesehatan mental seperti depresi, kecemasan, dan trauma.',
                'specialization' => 'Psikologi Klinis',
                'education' => 'S2 Psikologi Klinis, Universitas Indonesia',
                'experience' => '10+ tahun',
                'email' => 'sarah@psikologicenter.com',
                'phone' => '0812-3456-7890',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Michael Chen',
                'title' => 'M.Psi',
                'bio' => 'Spesialis dalam psikologi anak dan remaja dengan pendekatan terapi kognitif behavioral yang terbukti efektif.',
                'specialization' => 'Psikologi Anak dan Remaja',
                'education' => 'S2 Psikologi Pendidikan, UGM',
                'experience' => '8+ tahun',
                'email' => 'michael@psikologicenter.com',
                'phone' => '0813-4567-8901',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Amanda Putri',
                'title' => 'M.Psi, Psikolog',
                'bio' => 'Ahli dalam terapi keluarga dan konseling pernikahan dengan pendekatan holistik untuk menyelesaikan konflik.',
                'specialization' => 'Psikologi Keluarga',
                'education' => 'S2 Psikologi Klinis, Universitas Airlangga',
                'experience' => '7+ tahun',
                'email' => 'amanda@psikologicenter.com',
                'phone' => '0814-5678-9012',
                'is_active' => true,
            ],
        ];

        foreach ($psychologists as $psychologistData) {
            Psychologist::firstOrCreate(
                ['email' => $psychologistData['email']],
                $psychologistData
            );
        }

        // Create Services
        $services = [
            [
                'name' => 'Konseling Individual',
                'slug' => 'konseling-individual',
                'description' => 'Sesi konseling pribadi one-on-one dengan psikolog profesional untuk membahas masalah personal Anda seperti stress, kecemasan, depresi, atau masalah kehidupan lainnya.',
                'icon' => 'fas fa-user',
                'price' => 250000,
                'duration' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Terapi Keluarga',
                'slug' => 'terapi-keluarga',
                'description' => 'Terapi untuk mengatasi konflik keluarga, meningkatkan komunikasi antar anggota keluarga, dan membangun hubungan yang lebih harmonis.',
                'icon' => 'fas fa-users',
                'price' => 400000,
                'duration' => 90,
                'is_active' => true,
            ],
            [
                'name' => 'Konseling Pasangan',
                'slug' => 'konseling-pasangan',
                'description' => 'Membantu pasangan mengatasi masalah dalam hubungan, membangun komunikasi yang lebih baik, dan memperkuat ikatan emosional.',
                'icon' => 'fas fa-heart',
                'price' => 350000,
                'duration' => 90,
                'is_active' => true,
            ],
            [
                'name' => 'Konseling Anak & Remaja',
                'slug' => 'konseling-anak-remaja',
                'description' => 'Layanan khusus untuk membantu anak dan remaja mengatasi masalah emosional, perilaku, dan perkembangan.',
                'icon' => 'fas fa-child',
                'price' => 300000,
                'duration' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Tes Psikologi',
                'slug' => 'tes-psikologi',
                'description' => 'Asesmen psikologi komprehensif untuk mengetahui kondisi mental, kepribadian, dan potensi diri Anda.',
                'icon' => 'fas fa-clipboard-check',
                'price' => 500000,
                'duration' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'Terapi Online',
                'slug' => 'terapi-online',
                'description' => 'Sesi terapi jarak jauh melalui video call untuk Anda yang memiliki keterbatasan waktu atau lokasi.',
                'icon' => 'fas fa-video',
                'price' => 200000,
                'duration' => 60,
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::firstOrCreate(
                ['slug' => $serviceData['slug']],
                $serviceData
            );
        }

        // Create Articles
        $articles = [
            [
                'user_id' => $superAdminUser->id,
                'title' => '5 Cara Mengelola Stres di Tempat Kerja',
                'slug' => '5-cara-mengelola-stres-di-tempat-kerja',
                'excerpt' => 'Pelajari teknik efektif untuk mengurangi stres kerja dan meningkatkan produktivitas Anda.',
                'content' => 'Stres di tempat kerja adalah masalah umum yang dialami banyak orang. Berikut adalah 5 cara efektif untuk mengelola stres: 1. Atur waktu dengan baik, 2. Komunikasi yang efektif, 3. Istirahat yang cukup, 4. Olahraga teratur, 5. Teknik relaksasi seperti meditasi.',
                'category' => 'Kesehatan Mental',
                'is_published' => true,
                'published_at' => now(),
                'views' => 150,
            ],
            [
                'user_id' => $superAdminUser->id,
                'title' => 'Mengenal Depresi dan Cara Mengatasinya',
                'slug' => 'mengenal-depresi-dan-cara-mengatasinya',
                'excerpt' => 'Depresi adalah gangguan mental serius yang memerlukan penanganan profesional.',
                'content' => 'Depresi bukan hanya perasaan sedih biasa. Ini adalah kondisi medis yang mempengaruhi mood, pikiran, dan perilaku. Gejala depresi meliputi: kehilangan minat, perubahan nafsu makan, gangguan tidur, dan pikiran negatif. Penanganan yang tepat meliputi terapi psikologi dan konsultasi dengan profesional.',
                'category' => 'Psikologi Klinis',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views' => 200,
            ],
            [
                'user_id' => $superAdminUser->id,
                'title' => 'Tips Membangun Mental yang Kuat',
                'slug' => 'tips-membangun-mental-yang-kuat',
                'excerpt' => 'Mental yang kuat adalah kunci kesuksesan dan kebahagiaan hidup.',
                'content' => 'Membangun mental yang kuat memerlukan latihan dan komitmen. Tips: 1. Berpikir positif, 2. Terima kegagalan sebagai pembelajaran, 3. Jaga kesehatan fisik, 4. Bangun support system yang baik, 5. Praktikkan mindfulness.',
                'category' => 'Pengembangan Diri',
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'views' => 180,
            ],
        ];

        foreach ($articles as $articleData) {
            Article::firstOrCreate(
                ['slug' => $articleData['slug']],
                $articleData
            );
        }

        // Create Schedules
        $psychologist1 = Psychologist::where('email', 'sarah@psikologicenter.com')->first();
        if ($psychologist1) {
            $scheduleData = [
                ['day' => 'Senin', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                ['day' => 'Senin', 'start_time' => '13:00:00', 'end_time' => '17:00:00'],
                ['day' => 'Rabu', 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
                ['day' => 'Jumat', 'start_time' => '14:00:00', 'end_time' => '17:00:00'],
            ];

            foreach ($scheduleData as $schedule) {
                Schedule::firstOrCreate([
                    'psychologist_id' => $psychologist1->id,
                    'day' => $schedule['day'],
                    'start_time' => $schedule['start_time'],
                ], [
                    'end_time' => $schedule['end_time'],
                    'is_available' => true,
                ]);
            }
        }

        // Create Testimonials
        $testimonials = [
            [
                'name' => 'Rina S.',
                'content' => 'Layanan konseling di sini sangat membantu saya mengatasi kecemasan. Psikolognya sangat profesional dan caring!',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Budi W.',
                'content' => 'Terapi keluarga yang saya ikuti berhasil memperbaiki komunikasi dalam keluarga. Highly recommended!',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Siti M.',
                'content' => 'Konseling online sangat membantu saya yang sibuk. Fleksibel dan tetap efektif!',
                'rating' => 4,
                'is_approved' => true,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::firstOrCreate(
                ['name' => $testimonialData['name']],
                $testimonialData
            );
        }

        // Create Appointments
        $psychologist1 = Psychologist::where('email', 'sarah@psikologicenter.com')->first();
        $schedule = Schedule::where('psychologist_id', $psychologist1->id)->first();
        
        if ($psychologist1 && $schedule) {
            $appointments = [
                [
                    'user_id' => $regularUser->id,
                    'psychologist_id' => $psychologist1->id,
                    'schedule_id' => $schedule->id,
                    'name' => 'Rina S.',
                    'email' => 'rina@example.com',
                    'phone' => '0812-1234-5678',
                    'appointment_date' => now()->addDays(5)->format('Y-m-d'),
                    'complaint' => 'Stress dan kecemasan di tempat kerja',
                    'status' => 'confirmed',
                    'notes' => 'Follow up session',
                ],
                [
                    'user_id' => $regularUser->id,
                    'psychologist_id' => $psychologist1->id,
                    'schedule_id' => $schedule->id,
                    'name' => 'Budi W.',
                    'email' => 'budi@example.com',
                    'phone' => '0813-2345-6789',
                    'appointment_date' => now()->addDays(7)->format('Y-m-d'),
                    'complaint' => 'Masalah keluarga dan komunikasi',
                    'status' => 'pending',
                    'notes' => '',
                ],
            ];

            foreach ($appointments as $appointmentData) {
                Appointment::firstOrCreate(
                    ['email' => $appointmentData['email'], 'appointment_date' => $appointmentData['appointment_date']],
                    $appointmentData
                );
            }
        }

        // Create Webinars
        $webinars = [
            [
                'title' => 'Mengatasi Stress di Era Digital',
                'description' => 'Webinar interaktif tentang strategi mengatasi stress dan kecemasan di era digital dengan Dr. Sarah Johnson. Peserta akan belajar teknik relaksasi, mindfulness, dan manajemen waktu yang efektif.',
                'starts_at' => now()->addDays(10)->setHour(14)->setMinute(0),
                'link' => 'https://zoom.us/meeting/example1',
                'is_published' => true,
            ],
            [
                'title' => 'Psikologi Keluarga: Komunikasi yang Efektif',
                'description' => 'Webinar dengan fokus pada membangun komunikasi yang sehat dalam keluarga. Dipandu oleh Dr. Amanda Putri, peserta akan mempelajari cara mengatasi konflik dan membangun hubungan yang harmonis.',
                'starts_at' => now()->addDays(15)->setHour(15)->setMinute(0),
                'link' => 'https://zoom.us/meeting/example2',
                'is_published' => true,
            ],
            [
                'title' => 'Tumbuh Kembang Anak: Tips untuk Orang Tua',
                'description' => 'Webinar mendalam tentang psikologi perkembangan anak dan tips praktis untuk orang tua dalam membimbing anak-anak mereka. Dipandu oleh Dr. Michael Chen, ahli psikologi anak.',
                'starts_at' => now()->addDays(20)->setHour(10)->setMinute(0),
                'link' => 'https://zoom.us/meeting/example3',
                'is_published' => true,
            ],
        ];

        foreach ($webinars as $webinarData) {
            Webinar::firstOrCreate(
                ['title' => $webinarData['title']],
                $webinarData
            );
        }

        $this->command->info('✅ Data seeding completed successfully!');
    }
}