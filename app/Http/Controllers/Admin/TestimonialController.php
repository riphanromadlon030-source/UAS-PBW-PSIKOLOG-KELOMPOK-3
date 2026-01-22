<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
  
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => true]);

        return redirect()->back()
            ->with('success', 'Testimoni berhasil disetujui.');
    }

    public function reject(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => false]);

        return redirect()->back()
            ->with('success', 'Testimoni ditolak.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar) {
            Storage::disk('public')->delete($testimonial->avatar);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }

    public function edit(Testimonial $testimonial)
    {
        $psychologists = \App\Models\Psychologist::all();
        return view('admin.testimonials.edit', compact('testimonial', 'psychologists'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'service_type' => 'nullable|string|max:255',
            'content' => 'required|string',
            'psychologist_id' => 'nullable|exists:psychologists,id',
            'is_approved' => 'sometimes|boolean',
            'admin_notes' => 'nullable|string',
        ]);

        $data['is_approved'] = $request->has('is_approved') ? 1 : 0;

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }
}