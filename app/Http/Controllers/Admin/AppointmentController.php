<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentStatusUpdated;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
   

    public function index(Request $request)
    {
        $query = Appointment::with(['psychologist', 'jadwal', 'user']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%")
                  ->orWhere('telepon', 'LIKE', "%$search%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $appointments = $query->latest()->paginate(15);

        // Get statistics
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'in_progress' => Appointment::where('status', 'in_progress')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
        ];

        // Return appropriate view based on user role
        if ($request->user() && $request->user()->hasRole('Psychologist Admin')) {
            return view('psychologist-admin.appointments.index', compact('appointments', 'stats'));
        }

        return view('admin.appointments.index', compact('appointments', 'stats'));
    }

    public function psychologistAdminDashboard(Request $request)
    {
        // Get appointment statistics
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();
        $totalAppointments = Appointment::count();

        // Get recent appointments (last 10)
        $recentAppointments = Appointment::with(['client', 'psychologist.services'])
            ->latest()
            ->take(10)
            ->get();

        return view('psychologist-admin.dashboard', compact(
            'pendingAppointments',
            'confirmedAppointments',
            'totalAppointments',
            'recentAppointments'
        ));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['psychologist', 'jadwal', 'user']);

        // Return appropriate view based on user role
        if (auth()->user() && auth()->user()->hasRole('Psychologist Admin')) {
            return view('psychologist-admin.appointments.show', compact('appointment'));
        }

        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $appointment->status;
        $newStatus = $validated['status'];

        $appointment->update($validated);

        // Send email notification if status changed
        if ($oldStatus !== $newStatus) {
            try {
                Mail::to($appointment->email)->send(new AppointmentStatusUpdated($appointment, $oldStatus, $newStatus));
            } catch (\Exception $e) {
                // Log the error but don't fail the request
                \Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }

        return redirect()->back()
            ->with('success', 'Status janji temu berhasil diupdate.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Janji temu berhasil dihapus.');
    }

    // Mulai konseling (pending -> in_progress)
    public function startCounseling($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->update(['status' => 'in_progress']);
            return redirect()->back()->with('success', 'Konseling dimulai untuk: ' . $appointment->nama_lengkap);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Selesai konseling (in_progress -> completed)
    public function completeCounseling(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            
            $validated = $request->validate([
                'catatan_admin' => 'nullable|string|max:1000',
            ]);

            $appointment->update([
                'status' => 'completed',
                'catatan_admin' => $validated['catatan_admin'] ?? $appointment->catatan_admin,
            ]);

            return redirect()->back()->with('success', 'Konseling selesai untuk: ' . $appointment->nama_lengkap);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Reset appointment ke pending
    public function resetAppointment($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->update(['status' => 'pending']);
            return redirect()->back()->with('success', 'Appointment di-reset ke pending');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Statistics page
    public function statistics()
    {
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'in_progress' => Appointment::where('status', 'in_progress')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
        ];

        $psychologistStats = \App\Models\Psychologist::where('is_active', true)
            ->withCount([
                'appointments' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->get();

        $recentAppointments = Appointment::with(['psychologist', 'jadwal'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.appointments.statistics', compact('stats', 'psychologistStats', 'recentAppointments'));
    }
}
