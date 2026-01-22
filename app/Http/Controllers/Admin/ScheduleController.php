<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Psychologist;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
   
    

    public function index()
    {
        $schedules = Schedule::with('psychologist')->latest()->paginate(15);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $psychologists = Psychologist::where('is_active', true)->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.schedules.create', compact('psychologists', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'psychologist_id' => 'required|exists:psychologists,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'boolean',
        ]);

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        $psychologists = Psychologist::where('is_active', true)->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.schedules.edit', compact('schedule', 'psychologists', 'days'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'psychologist_id' => 'required|exists:psychologists,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'boolean',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
