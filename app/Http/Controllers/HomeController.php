<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Psychologist;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPsychologists = Psychologist::where('is_active', true)->take(3)->get();
        $services = Service::where('is_active', true)->take(6)->get();
        $recentArticles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        $testimonials = Testimonial::where('is_approved', true)->take(6)->get();

        return view('public.home', compact('featuredPsychologists', 'services', 'recentArticles', 'testimonials'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Di sini bisa ditambahkan logika untuk mengirim email atau menyimpan ke database
        // Untuk sekarang, kita hanya redirect dengan pesan sukses

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}