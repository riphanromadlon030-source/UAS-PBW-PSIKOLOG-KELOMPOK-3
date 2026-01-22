<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use Illuminate\Http\Request;

class WebinarController extends Controller
{
    public function index()
    {
        $webinars = Webinar::latest()->paginate(15);
        return view('admin.webinars.index', compact('webinars'));
    }

    public function create()
    {
        return view('admin.webinars.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starts_at' => 'nullable|date',
            'link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'sometimes|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('webinars', 'public');
            $data['image'] = $imagePath;
        }

        // Handle poster upload
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('webinars', 'public');
            $data['poster'] = $posterPath;
        }

        $data['is_published'] = $request->has('is_published');

        Webinar::create($data);

        return redirect()->route('admin.webinars.index')->with('success', 'Webinar berhasil dibuat.');
    }

    public function edit(Webinar $webinar)
    {
        return view('admin.webinars.edit', compact('webinar'));
    }

    public function update(Request $request, Webinar $webinar)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starts_at' => 'nullable|date',
            'link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'sometimes|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($webinar->image && \Storage::disk('public')->exists($webinar->image)) {
                \Storage::disk('public')->delete($webinar->image);
            }
            $imagePath = $request->file('image')->store('webinars', 'public');
            $data['image'] = $imagePath;
        }

        // Handle poster upload
        if ($request->hasFile('poster')) {
            // Delete old poster if exists
            if ($webinar->poster && \Storage::disk('public')->exists($webinar->poster)) {
                \Storage::disk('public')->delete($webinar->poster);
            }
            $posterPath = $request->file('poster')->store('webinars', 'public');
            $data['poster'] = $posterPath;
        }

        $data['is_published'] = $request->has('is_published');

        $webinar->update($data);

        return redirect()->route('admin.webinars.index')->with('success', 'Webinar berhasil diupdate.');
    }

    public function destroy(Webinar $webinar)
    {
        // Delete images
        if ($webinar->image && \Storage::disk('public')->exists($webinar->image)) {
            \Storage::disk('public')->delete($webinar->image);
        }
        if ($webinar->poster && \Storage::disk('public')->exists($webinar->poster)) {
            \Storage::disk('public')->delete($webinar->poster);
        }
        
        $webinar->delete();
        return redirect()->route('admin.webinars.index')->with('success', 'Webinar berhasil dihapus.');
    }

    public function togglePublish(Webinar $webinar)
    {
        $webinar->is_published = !$webinar->is_published;
        $webinar->save();

        return redirect()->route('admin.webinars.index')->with('success', 'Status webinar berhasil diubah.');
    }
}
