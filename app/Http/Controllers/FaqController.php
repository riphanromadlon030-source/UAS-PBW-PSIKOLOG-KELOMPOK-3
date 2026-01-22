<?php

namespace App\Http\Controllers; // Jika file dipindah ke folder Admin, ubah jadi: App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::query();

        // Logika Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // CEK: Jika URL mengandung kata 'admin', tampilkan halaman Admin
        if ($request->is('admin/*')) {
            $faqs = $query->orderBy('order', 'asc')->paginate(10);
            $categories = ['general', 'appointment', 'payment', 'therapy', 'other'];
            return view('admin.faqs.index', compact('faqs', 'categories'));
        }

        // JIKA TIDAK: Tampilkan halaman Publik (User)
        // Dapatkan semua FAQ dan kelompokkan berdasarkan kategori
        $allFaqs = $query->orderBy('order', 'asc')->get();
        
        // Inisialisasi array kategori kosong
        $faqs = [
            'general' => collect(),
            'appointment' => collect(),
            'payment' => collect(),
            'therapy' => collect(),
            'other' => collect(),
        ];
        
        // Jika tidak ada kategori di database, pisahkan berdasarkan order
        // Kelompok pertama (order 1-5): general
        // Kelompok kedua (order 6-10): appointment
        // Dan seterusnya
        foreach ($allFaqs as $faq) {
            if ($faq->order >= 1 && $faq->order <= 5) {
                $faqs['general']->push($faq);
            } elseif ($faq->order >= 6 && $faq->order <= 10) {
                $faqs['appointment']->push($faq);
            } elseif ($faq->order >= 11 && $faq->order <= 15) {
                $faqs['payment']->push($faq);
            } elseif ($faq->order >= 16 && $faq->order <= 20) {
                $faqs['therapy']->push($faq);
            } else {
                $faqs['other']->push($faq);
            }
        }
                  
        // Tampilkan halaman publik: resources/views/public/faqs/index.blade.php
        return view('public.faqs.index', compact('faqs')); 
    }

    public function create()
    {
        // Diubah: Mengarah ke folder admin/faq
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil ditambahkan');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil diupdate');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        // Diubah: Redirect ke route admin.faq.index
        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus');
    }
}