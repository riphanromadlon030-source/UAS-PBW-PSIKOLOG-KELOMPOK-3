<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ContactController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PsychologistController as AdminPsychologistController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\WebinarController as AdminWebinarController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;

// Psychologist Controllers
use App\Http\Controllers\Psychologist\DashboardController as PsychologistDashboardController;
use App\Http\Controllers\Psychologist\AppointmentController as PsychologistAppointmentController;
use App\Http\Controllers\Psychologist\ScheduleController as PsychologistScheduleController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Sesuaikan nama controller yang Anda miliki
Route::post('/contact/submit', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.submit');

// Psychologists (Public)
Route::get('/psychologists', [PsychologistController::class, 'index'])->name('psychologists');
Route::get('/psychologists/{id}', [PsychologistController::class, 'show'])->name('psychologists.show');

// Services (Public)
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Articles (Public)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Appointments (Public)
Route::middleware(['auth'])->group(function () {
    Route::get('/appointments/create/{psychologist_id?}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::get('/appointments/psychologists/{service_id}', [AppointmentController::class, 'getPsychologists'])->name('appointments.psychologists');
    Route::get('/appointments/schedules/{psychologist_id}', [AppointmentController::class, 'getSchedules'])->name('appointments.schedules');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

// Testimonials (Public)
Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

// Webinars (Public)
Route::get('/webinars', [App\Http\Controllers\WebinarController::class, 'index'])->name('webinars.index');
Route::get('/webinars/{webinar}', [App\Http\Controllers\WebinarController::class, 'show'])->name('webinars.show');

// Jadwal Konseling (Public)
Route::get('/jadwals', [JadwalController::class, 'index'])->name('jadwals.index');
// Routes dengan path spesifik harus sebelum route dengan parameter
Route::get('/jadwals/completed/page', [JadwalController::class, 'completedPatientPage'])->name('jadwals.completed-page');
Route::get('/jadwals/completed/patients', [JadwalController::class, 'completedPatients'])->name('jadwals.completed');
Route::get('/jadwals/pending/appointments', [JadwalController::class, 'pendingAppointments'])->name('jadwals.pending');
Route::get('/jadwals/in-progress/appointments', [JadwalController::class, 'inProgressAppointments'])->name('jadwals.in-progress');
Route::get('/jadwals/statistics/page', [JadwalController::class, 'statisticsPage'])->name('jadwals.statistics-page');
Route::get('/jadwals/stats/all', [JadwalController::class, 'getStats'])->name('jadwals.stats');
// Appointment actions - sebelum route {id}
Route::post('/jadwals/appointment/{id}/mark-completed', [JadwalController::class, 'markCompleted'])->name('jadwals.mark-completed');
Route::post('/jadwals/appointment/{id}/start-counseling', [JadwalController::class, 'startCounseling'])->name('jadwals.start-counseling');
// Routes dengan parameter harus paling akhir
Route::get('/jadwals/{id}', [JadwalController::class, 'show'])->name('jadwals.show');
Route::post('/jadwals/{id}/book', [JadwalController::class, 'book'])->name('jadwals.book');

// FAQ (Public) ✅ cukup satu
Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq.index');

// Tests (Public)
Route::get('/tests', [App\Http\Controllers\TestController::class, 'index'])->name('tests.index');
Route::get('/tests/{id}', [App\Http\Controllers\TestController::class, 'show'])->name('tests.show');
Route::post('/tests/{id}/submit', [App\Http\Controllers\TestController::class, 'submit'])->name('tests.submit');


/*
|--------------------------------------------------------------------------
| Authenticated Routes (User)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // ✅ Dashboard hanya 1 kali
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Redirect berdasarkan role Spatie
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('Psychologist') || $user->hasRole('Counselor')) {
            return redirect()->route('psychologist.dashboard');
        }

        // User biasa
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Contacts (Admin)
        Route::get('contacts', [ContactController::class, 'indexAdmin'])->name('contacts.index');
        Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
        Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
        Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

        // User Management
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Psychologists
        Route::resource('psychologists', AdminPsychologistController::class);

        // Services
        Route::resource('services', AdminServiceController::class)->except(['show']);

        // Articles
        Route::resource('articles', AdminArticleController::class)->except(['show']);

        // Schedules
        Route::resource('schedules', AdminScheduleController::class)->except(['show']);

        // Appointments
        Route::get('appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/{appointment}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
        Route::post('appointments/{id}/start-counseling', [AdminAppointmentController::class, 'startCounseling'])->name('appointments.start-counseling');
        Route::post('appointments/{id}/complete-counseling', [AdminAppointmentController::class, 'completeCounseling'])->name('appointments.complete-counseling');
        Route::post('appointments/{id}/reset', [AdminAppointmentController::class, 'resetAppointment'])->name('appointments.reset');
        Route::get('appointments/statistics/page', [AdminAppointmentController::class, 'statistics'])->name('appointments.statistics');
        Route::delete('appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');

        // Testimonials
        Route::get('testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
        Route::get('testimonials/{testimonial}/edit', [AdminTestimonialController::class, 'edit'])->name('testimonials.edit');
        Route::put('testimonials/{testimonial}', [AdminTestimonialController::class, 'update'])->name('testimonials.update');
        Route::patch('testimonials/{testimonial}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');
        Route::patch('testimonials/{testimonial}/reject', [AdminTestimonialController::class, 'reject'])->name('testimonials.reject');
        Route::delete('testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

        // Webinars (Admin)
        Route::resource('webinars', App\Http\Controllers\Admin\WebinarController::class)->except(['show']);
        Route::patch('webinars/{webinar}/toggle-publish', [App\Http\Controllers\Admin\WebinarController::class, 'togglePublish'])->name('webinars.togglePublish');

        // Jadwals
        Route::resource('jadwals', AdminJadwalController::class);

        // Clients
        Route::resource('clients', AdminClientController::class);

        // FAQs
        Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class);
    });


/*
|--------------------------------------------------------------------------
| Psychologist Routes
|--------------------------------------------------------------------------
*/
Route::prefix('psychologist')
    ->middleware(['auth', 'verified'])
    ->name('psychologist.')
    ->group(function () {

        Route::get('/dashboard', [PsychologistDashboardController::class, 'index'])->name('dashboard');
    });


/*
|--------------------------------------------------------------------------
| Psychologist Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('psychologist-admin')
    ->middleware(['auth', 'verified', 'psychologist.admin'])
    ->name('psychologist-admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminAppointmentController::class, 'psychologistAdminDashboard'])->name('dashboard');

        // Appointments only
        Route::get('appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/{appointment}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
        Route::post('appointments/{id}/start-counseling', [AdminAppointmentController::class, 'startCounseling'])->name('appointments.start-counseling');
        Route::post('appointments/{id}/complete-counseling', [AdminAppointmentController::class, 'completeCounseling'])->name('appointments.complete-counseling');
        Route::post('appointments/{id}/reset', [AdminAppointmentController::class, 'resetAppointment'])->name('appointments.reset');
        Route::get('appointments/statistics/page', [AdminAppointmentController::class, 'statistics'])->name('appointments.statistics');
        Route::delete('appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');
    });

/*
|--------------------------------------------------------------------------
| System Maintenance Routes
|--------------------------------------------------------------------------
*/
Route::get('/system/fix-enum', function () {
    try {
        $pdo = new PDO(
            "mysql:host=" . env('DB_HOST', '127.0.0.1') . ";dbname=" . env('DB_DATABASE') . ";charset=utf8mb4",
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        // Check current ENUM values
        $result = $pdo->query('SHOW COLUMNS FROM appointments WHERE Field = "status"')->fetch(PDO::FETCH_ASSOC);
        $currentType = $result['Type'] ?? '';

        // Fix the ENUM - add 'in_progress' if missing
        if (strpos($currentType, 'in_progress') === false) {
            $pdo->exec("ALTER TABLE appointments MODIFY status ENUM('pending', 'in_progress', 'completed', 'confirmed', 'cancelled') DEFAULT 'pending' NOT NULL COLLATE utf8mb4_unicode_ci");
            
            // Verify the fix
            $result = $pdo->query('SHOW COLUMNS FROM appointments WHERE Field = "status"')->fetch(PDO::FETCH_ASSOC);
            return response()->json([
                'success' => true,
                'message' => 'ENUM fixed successfully!',
                'old_type' => $currentType,
                'new_type' => $result['Type']
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'in_progress already exists in ENUM',
                'current_type' => $currentType
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});

require __DIR__.'/auth.php';
