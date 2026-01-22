<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use Illuminate\Http\Request;

class PsychologistController extends Controller
{
    public function index(Request $request)
    {
        $query = Psychologist::where('is_active', true);

        // Filter by specialization
        if ($request->has('specialization') && $request->specialization != '') {
            $query->where('specialization', 'like', '%' . $request->specialization . '%');
        }

        // Filter by search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('bio', 'like', '%' . $request->search . '%');
            });
        }

        // Get paginated psychologists
        $psychologists = $query->paginate(9);
        
        // Get unique specializations for filter dropdown
        $specializations = Psychologist::where('is_active', true)
            ->distinct()
            ->pluck('specialization');

        // Return view with both variables
        return view('public.psychologists.index', compact('psychologists', 'specializations'));
    }

    public function show($id)
    {
        $psychologist = Psychologist::with('schedules')->findOrFail($id);
        
        if (!$psychologist->is_active) {
            abort(404);
        }

        return view('public.psychologists.show', compact('psychologist'));
    }
}