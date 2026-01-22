<?php

namespace App\Http\Controllers\Psychologist;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('psychologist_id', auth()->id())->get();
        return view('psychologist.schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('psychologist.schedules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Schedule::create([
            'psychologist_id' => auth()->id(),
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_available' => true,
        ]);

        return redirect()->route('psychologist.schedules.index');
    }

    public function show(Schedule $schedule)
    {
        if ($schedule->psychologist_id !== auth()->id()) {
            abort(403);
        }
        return view('psychologist.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        if ($schedule->psychologist_id !== auth()->id()) {
            abort(403);
        }
        return view('psychologist.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        if ($schedule->psychologist_id !== auth()->id()) {
            abort(403);
        }
        $schedule->update($request->all());
        return redirect()->route('psychologist.schedules.index');
    }

    public function destroy(Schedule $schedule)
    {
        if ($schedule->psychologist_id !== auth()->id()) {
            abort(403);
        }
        $schedule->delete();
        return redirect()->route('psychologist.schedules.index');
    }
}
