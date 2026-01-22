<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
use App\Models\Contact;

class ContactController extends Controller
{
    // READ - Tampilkan daftar pesan
    public function indexAdmin()
    {
        $messages = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('messages'));
    }

    // READ - Tampilkan detail pesan
    public function show(Contact $contact)
    {
        // Mark as read if not already read
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    // CREATE - Simpan pesan dari form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);
        return redirect()->back()->with('success', 'Pesan terkirim!');
    }

    // UPDATE - Form edit
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    // UPDATE - Simpan perubahan
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contact->update($validated);
        return redirect()->route('admin.contacts.index')->with('success', 'Pesan diperbarui!');
    }

    // DELETE - Hapus pesan
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->back()->with('success', 'Pesan dihapus!');
    }

    // REPLY - Balas pesan
    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $contact->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_at' => now(),
        ]);

        // Kirim email ke user
        try {
            Mail::to($contact->email)->send(new ContactReplyMail($contact));
        } catch (\Exception $e) {
            // Log error tapi jangan hentikan proses
            \Log::error('Failed to send contact reply email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Balasan berhasil dikirim!');
    }
}