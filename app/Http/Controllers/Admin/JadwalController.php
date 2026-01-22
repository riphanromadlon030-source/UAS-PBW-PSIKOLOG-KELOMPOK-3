<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Psychologist;
use Illuminate\Http\Request;

class JadwalController extends Controller
{

    public function index()
    {
        $jadwals = Jadwal::with('psychologist')->latest()->paginate(15);
        return view('admin.jadwals.index', compact('jadwals'));
    }

    public function create()
    {
        $psychologists = Psychologist::where('is_active', true)->get();
        return view('admin.jadwals.create', compact('psychologists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'psychologist_id' => 'required|exists:psychologists,id',
            'judul' => 'required|string|max:255',
            'tanggal_waktu' => 'required|date',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'is_available' => 'boolean',
        ]);

        Jadwal::create($validated);

        return redirect()->route('admin.jadwals.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        $psychologists = Psychologist::where('is_active', true)->get();
        return view('admin.jadwals.edit', compact('jadwal', 'psychologists'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'psychologist_id' => 'required|exists:psychologists,id',
            'judul' => 'required|string|max:255',
            'tanggal_waktu' => 'required|date',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'is_available' => 'boolean',
        ]);

        $jadwal->update($validated);

        return redirect()->route('admin.jadwals.index')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwals.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}