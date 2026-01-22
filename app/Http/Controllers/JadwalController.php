<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Appointment;
use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
public function index(Request $request)
{
    // Ambil jadwal yang tersedia, eager-load psychologist, dan paginasi
    $query = Jadwal::with('psychologist')
        ->where('is_available', true);

    if ($request->filled('psychologist_id')) {
        $query->where('psychologist_id', $request->psychologist_id);
    }

    $jadwals = $query->orderBy('tanggal_waktu', 'asc')
        ->paginate(9)
        ->withQueryString();

    // Ambil psikolog aktif untuk filter (jika diperlukan oleh view)
    $psychologists = Psychologist::where('is_active', true)->get();

    return view('public.jadwals.index', compact('jadwals', 'psychologists'));
}

    public function show($id)
    {
        $jadwal = Jadwal::with('psychologist')->findOrFail($id);
        
        if (!$jadwal->is_available || $jadwal->isFullyBooked()) {
            return redirect()->route('jadwals.index')
                ->with('error', 'Jadwal tidak tersedia atau sudah penuh.');
        } 

        return view('public.jadwals.show', compact('jadwal'));
    }

    public function book(Request $request, $id)
    {
        $jadwal = Jadwal::with('psychologist.services')->findOrFail($id);

        if ($jadwal->isFullyBooked()) {
            return redirect()->back()->with('error', 'Jadwal sudah penuh.');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'telepon' => 'required|string|max:20',
            'keluhan' => 'nullable|string',
        ]);

        // Map form fields to database fields
        $appointmentData = [
            'jadwal_id' => $jadwal->id,
            'psychologist_id' => $jadwal->psychologist_id,
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'keluhan' => $validated['keluhan'] ?? null,
            'status' => 'pending',
            'booking_type' => 'booking',
            'user_id' => Auth::id(),
        ];

        // Get first service from psychologist for booking
        $serviceId = $jadwal->psychologist ? $jadwal->psychologist->services()->first()?->id : null;
        if ($serviceId) {
            $appointmentData['service_id'] = $serviceId;
        }

        Appointment::create($appointmentData);

        return redirect()->route('jadwals.index')
            ->with('success', 'Booking berhasil! Kami akan menghubungi Anda segera.');
    }

    public function completedPatients()
    {
        $completedCount = Appointment::where('status', 'completed')->count();
        
        return response()->json([
            'completed_patients' => $completedCount,
            'message' => 'Jumlah pasien yang sudah selesai konseling'
        ]);
    }

    public function getStats()
    {
        $stats = [
            'completed_patients' => Appointment::where('status', 'completed')->count(),
            'pending_patients' => Appointment::where('status', 'pending')->count(),
            'in_progress_patients' => Appointment::where('status', 'in_progress')->count(),
            'total_patients' => Appointment::count(),
        ];
        
        return response()->json($stats);
    }

    public function completedPatientPage()
    {
        $completedPatients = Appointment::where('status', 'completed')
            ->with('psychologist')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('public.jadwals.completed-patients', compact('completedPatients'));
    }

    public function markCompleted(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->update(['status' => 'completed']);
            return redirect()->back()->with('success', 'Pasien berhasil ditandai selesai konseling');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function startCounseling(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->update(['status' => 'in_progress']);
            return redirect()->back()->with('success', 'Pasien berhasil dimulai sesi konseling');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function pendingAppointments()
    {
        $appointments = Appointment::where('status', 'pending')
            ->with(['psychologist', 'jadwal'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('public.jadwals.pending-appointments', compact('appointments'));
    }

    public function inProgressAppointments()
    {
        $appointments = Appointment::where('status', 'in_progress')
            ->with(['psychologist', 'jadwal'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('public.jadwals.in-progress-appointments', compact('appointments'));
    }

    public function statisticsPage()
    {
        $stats = [
            'completed_count' => Appointment::where('status', 'completed')->count(),
            'pending_count' => Appointment::where('status', 'pending')->count(),
            'in_progress_count' => Appointment::where('status', 'in_progress')->count(),
            'total_count' => Appointment::count(),
            'completion_rate' => Appointment::count() > 0 ? round((Appointment::where('status', 'completed')->count() / Appointment::count()) * 100, 1) : 0,
        ];

        // Data untuk grafik per psikolog
        $psychologistStats = Psychologist::where('is_active', true)
            ->withCount([
                'appointments' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->get()
            ->map(function ($psychologist) {
                return [
                    'name' => $psychologist->name,
                    'completed' => $psychologist->appointments_count,
                ];
            });

        // Data appointments per status
        $appointmentsByStatus = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'in_progress' => Appointment::where('status', 'in_progress')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
        ];

        // Recent appointments
        $recentAppointments = Appointment::with(['psychologist', 'jadwal'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('public.jadwals.statistics', compact('stats', 'psychologistStats', 'appointmentsByStatus', 'recentAppointments'));
    }
}