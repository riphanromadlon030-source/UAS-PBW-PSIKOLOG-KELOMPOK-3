<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $psychologist = $user->psychologist;

        if (!$psychologist) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai psikolog.');
        }

        // Statistics
        $totalAppointments = Appointment::where('psychologist_id', $psychologist->id)->count();
        $pendingAppointments = Appointment::where('psychologist_id', $psychologist->id)
            ->where('status', 'pending')
            ->count();
        $confirmedAppointments = Appointment::where('psychologist_id', $psychologist->id)
            ->where('status', 'confirmed')
            ->count();
        $completedAppointments = Appointment::where('psychologist_id', $psychologist->id)
            ->where('status', 'completed')
            ->count();

        // Recent Appointments
        $recentAppointments = Appointment::where('psychologist_id', $psychologist->id)
            ->with('psychologist')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Upcoming Schedules
        $upcomingSchedules = Jadwal::where('psychologist_id', $psychologist->id)
            ->where('tanggal', '>=', now())
            ->where('status', 'available')
            ->orderBy('tanggal', 'asc')
            ->limit(5)
            ->get();

        return view('psychologist.dashboard', compact(
            'psychologist',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'completedAppointments',
            'recentAppointments',
            'upcomingSchedules'
        ));
    }
}