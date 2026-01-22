<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Psychologist;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create($psychologist_id = null)
    {
        $services = Service::where('is_active', true)->get();
        $psychologists = collect(); // Start with empty collection
        $selectedPsychologist = $psychologist_id ? Psychologist::findOrFail($psychologist_id) : null;
        $schedules = $selectedPsychologist ? $selectedPsychologist->schedules()->where('is_available', true)->get() : collect();

        return view('public.appointments.create', compact('services', 'psychologists', 'selectedPsychologist', 'schedules'));
    }

    public function getPsychologists($service_id)
    {
        $psychologists = Psychologist::where('is_active', true)
            ->whereHas('services', function($query) use ($service_id) {
                $query->where('service_id', $service_id);
            })
            ->select('id', 'name', 'specialization')
            ->get();

        return response()->json($psychologists);
    }

    public function getSchedules($psychologist_id)
    {
        $schedules = Schedule::where('psychologist_id', $psychologist_id)
            ->where('is_available', true)
            ->select('id', 'day', 'start_time', 'end_time')
            ->get();

        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'psychologist_id' => 'required|exists:psychologists,id',
            'schedule_id' => 'required|exists:schedules,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'appointment_date' => 'required|date|after:today',
            'complaint' => 'nullable|string',
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            // Try to find existing user by email
            $user = \App\Models\User::where('email', $validated['email'])->first();

            if (!$user) {
                // Create new user account
                $user = \App\Models\User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'password' => bcrypt('password123'), // Default password
                    'is_active' => true,
                ]);

                // Assign default role (use 'User' role for clients)
                $user->assignRole('User');
            }

            // Log the user in
            Auth::login($user);
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Appointment::create($validated);

        return redirect()->route('dashboard')->with('success', 'Janji temu berhasil dibuat! Selamat datang di dashboard klien Anda.');
    }

    public function myAppointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->with(['psychologist', 'service', 'schedule'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('public.appointments.my-appointments', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        // Ensure user can only view their own appointments
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $appointment->load(['psychologist', 'service', 'schedule']);

        return view('public.appointments.show', compact('appointment'));
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        // Ensure user can only cancel their own appointments
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Only allow cancellation of pending or confirmed appointments
        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'Janji temu ini tidak dapat dibatalkan.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'] ?? null,
        ]);

        return redirect()->route('appointments.my')->with('success', 'Janji temu berhasil dibatalkan.');
    }
}