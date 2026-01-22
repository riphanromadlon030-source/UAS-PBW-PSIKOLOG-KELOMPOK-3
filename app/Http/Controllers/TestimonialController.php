<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_approved', true)
            ->latest()
            ->paginate(12);
        
        $totalTestimonials = Testimonial::where('is_approved', true)->count();
        $averageRating = Testimonial::where('is_approved', true)->avg('rating') ?: 0;
        
        return view('public.testimonials.index', compact('testimonials', 'totalTestimonials', 'averageRating'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'rating'      => 'required|integer|min:1|max:5',
            'service_type' => 'nullable|string|max:255',
            'testimonial' => 'required|string',
        ]);

        $validated['is_approved'] = true;
        $validated['name'] = $validated['client_name'];
        $validated['content'] = $validated['testimonial'];
        unset($validated['client_name']);
        unset($validated['testimonial']);
        
        // If user is authenticated, add their user_id
        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        Testimonial::create($validated);

        return redirect()->back()
            ->with('success', 'Terima kasih! Testimoni Anda telah ditampilkan.');
    }
}
