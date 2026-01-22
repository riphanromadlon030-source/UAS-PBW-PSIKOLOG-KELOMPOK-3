<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.user-management.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user-management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:user,psychologist,admin'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            
            // Psychologist specific fields
            'phone' => ['required_if:role,psychologist', 'nullable', 'string', 'max:20'],
            'specialization' => ['required_if:role,psychologist', 'nullable', 'string', 'max:255'],
            'experience_years' => ['required_if:role,psychologist', 'nullable', 'integer', 'min:0'],
            'education' => ['required_if:role,psychologist', 'nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'license_number' => ['nullable', 'string', 'max:100'],
        ]);

        // Handle foto profil upload
        $fotoPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'foto_profil' => $fotoPath,
            'email_verified_at' => now(),
        ]);

        // If role is psychologist, create psychologist profile
        if ($validated['role'] === 'psychologist') {
            Psychologist::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'specialization' => $validated['specialization'],
                'experience_years' => $validated['experience_years'],
                'education' => $validated['education'],
                'bio' => $validated['bio'] ?? null,
                'license_number' => $validated['license_number'] ?? null,
                'photo' => $fotoPath,
                'status' => 'active',
            ]);
        }

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.user-management.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:user,psychologist,admin'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            
            // Psychologist specific fields
            'phone' => ['required_if:role,psychologist', 'nullable', 'string', 'max:20'],
            'specialization' => ['required_if:role,psychologist', 'nullable', 'string', 'max:255'],
            'experience_years' => ['required_if:role,psychologist', 'nullable', 'integer', 'min:0'],
            'education' => ['required_if:role,psychologist', 'nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'license_number' => ['nullable', 'string', 'max:100'],
        ]);

        // Handle foto profil upload
        if ($request->hasFile('foto_profil')) {
            // Delete old photo
            if ($user->foto_profil && \Storage::disk('public')->exists($user->foto_profil)) {
                \Storage::disk('public')->delete($user->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'foto_profil' => $validated['foto_profil'] ?? $user->foto_profil,
        ]);

        // Update or create psychologist profile
        if ($validated['role'] === 'psychologist') {
            $psychologist = $user->psychologist;
            
            $psychologistData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'specialization' => $validated['specialization'],
                'experience_years' => $validated['experience_years'],
                'education' => $validated['education'],
                'bio' => $validated['bio'] ?? null,
                'license_number' => $validated['license_number'] ?? null,
                'photo' => $validated['foto_profil'] ?? $user->foto_profil,
            ];

            if ($psychologist) {
                $psychologist->update($psychologistData);
            } else {
                Psychologist::create(array_merge($psychologistData, [
                    'user_id' => $user->id,
                    'status' => 'active',
                ]));
            }
        }

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        // Delete psychologist profile if exists
        if ($user->psychologist) {
            $user->psychologist->delete();
        }

        // Delete photo
        if ($user->foto_profil && \Storage::disk('public')->exists($user->foto_profil)) {
            \Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();

        return redirect()->route('admin.user-management.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function toggleStatus(User $user)
    {
        // Toggle psychologist status if exists
        if ($user->psychologist) {
            $newStatus = $user->psychologist->status === 'active' ? 'inactive' : 'active';
            $user->psychologist->update(['status' => $newStatus]);
            
            return back()->with('success', 'Status berhasil diubah menjadi ' . $newStatus);
        }

        return back()->with('error', 'User tidak memiliki profil psychologist!');
    }
}