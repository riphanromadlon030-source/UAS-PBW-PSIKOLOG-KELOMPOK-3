<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('psychologist_id', auth()->id())->get();
        return view('psychologist.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        // Ensure the appointment belongs to the psychologist
        if ($appointment->psychologist_id !== auth()->id()) {
            abort(403);
        }
        return view('psychologist.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Ensure the appointment belongs to the psychologist
        if ($appointment->psychologist_id !== auth()->id()) {
            abort(403);
        }
        $appointment->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated');
    }
}
