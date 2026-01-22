<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Psychologist;
use App\Models\Article;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Client;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    
    {
        // Get statistics
        $totalUsers = User::count();
        $totalPsychologists = Psychologist::where('is_active', true)->count();
        $totalArticles = Article::count();
        $totalAppointments = Appointment::count();
        $totalContacts = \App\Models\Contact::count();
        $unreadContacts = \App\Models\Contact::where('is_read', false)->count();
        
        // Appointment statistics by status
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        
        // Recent appointments
        $recentAppointments = Appointment::with('psychologist')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Recent articles
        $recentArticles = Article::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Additional statistics
        $totalServices = Service::count();
        $totalClients = User::where('role', 'user')->count();
        $totalTestimonials = Testimonial::count();
        $approvedTestimonials = Testimonial::where('is_approved', true)->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPsychologists',
            'totalArticles',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'completedAppointments',
            'recentAppointments',
            'recentArticles',
            'totalServices',
            'totalClients',
            'totalTestimonials',
            'approvedTestimonials',
            'totalContacts',
            'unreadContacts'
        ));
    }
}           