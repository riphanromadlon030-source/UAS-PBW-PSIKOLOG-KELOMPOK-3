<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];
    

    // Role Check Methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPsychologist(): bool
    {
        return $this->role === 'psychologist';
    }

    public function isCounselor(): bool
    {
        return $this->role === 'counselor';
    }

    // Scope Methods
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopePsychologists($query)
    {
        return $query->where('role', 'psychologist');
    }

    public function scopeCounselors($query)
    {
        return $query->where('role', 'counselor');
    }

    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relationships
    public function psychologist()
    {
        return $this->hasOne(Psychologist::class);
    }

    public function counselor()
    {
        return $this->hasOne(Counselor::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }
}