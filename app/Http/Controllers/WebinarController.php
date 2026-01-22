<?php

namespace App\Http\Controllers;

use App\Models\Webinar;

class WebinarController extends Controller
{
    public function index()
    {
        $webinars = Webinar::where('is_published', true)->latest()->paginate(12);
        return view('public.webinars.index', compact('webinars'));
    }

    public function show(Webinar $webinar)
    {
        abort_unless($webinar->is_published, 404);
        return view('public.webinars.show', compact('webinar'));
    }
}
