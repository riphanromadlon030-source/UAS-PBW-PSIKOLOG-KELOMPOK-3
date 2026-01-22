<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PsychologistController extends Controller
{
    // HAPUS SEMUA MIDDLEWARE DI __construct
    
    public function index()
    {
        $psychologists = Psychologist::latest()->paginate(10);
        return view('admin.psychologists.index', compact('psychologists'));
    }

    public function create()
    {
        return view('admin.psychologists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'specialization' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'education' => 'nullable|string',
            'experience' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:psychologists',
            'bio' => 'required|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('psychologists', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Psychologist::create($validated);

        return redirect()->route('admin.psychologists.index')
            ->with('success', 'Psychologist created successfully');
    }

    public function show(Psychologist $psychologist)
    {
        return view('admin.psychologists.show', compact('psychologist'));
    }

    public function edit(Psychologist $psychologist)
    {
        return view('admin.psychologists.edit', compact('psychologist'));
    }

    public function update(Request $request, Psychologist $psychologist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'experience_years' => 'required|integer|min:0',
            'education' => 'required|string',
            'license_number' => 'required|string|unique:psychologists,license_number,' . $psychologist->id,
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:psychologists,email,' . $psychologist->id,
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($psychologist->photo) {
                Storage::disk('public')->delete($psychologist->photo);
            }
            $validated['photo'] = $request->file('photo')->store('psychologists', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $psychologist->update($validated);

        return redirect()->route('admin.psychologists.index')
            ->with('success', 'Psychologist updated successfully');
    }

    public function destroy(Psychologist $psychologist)
    {
        if ($psychologist->photo) {
            Storage::disk('public')->delete($psychologist->photo);
        }

        $psychologist->delete();

        return redirect()->route('admin.psychologists.index')
            ->with('success', 'Psychologist deleted successfully');
    }
}