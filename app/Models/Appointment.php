<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'psychologist_id',
        'counselor_id',
        'schedule_id',
        'jadwal_id',
        'service_id',
        'name',
        'nama_lengkap',
        'email',
        'phone',
        'telepon',
        'appointment_date',
        'complaint',
        'keluhan',
        'status',
        'notes',
        'catatan_admin',
        'booking_type',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    /**
     * Get the appointment's full name.
     * Returns nama_lengkap if available, otherwise returns name field
     */
    public function getFullNameAttribute()
    {
        return $this->nama_lengkap ?? $this->name ?? 'Unknown';
    }

    /**
     * Get the appointment's display name for views
     */
    public function getDisplayNameAttribute()
    {
        return $this->full_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
