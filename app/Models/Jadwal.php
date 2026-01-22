<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'psychologist_id',
        'counselor_id',
        'judul',
        'tanggal_waktu',
        'deskripsi',
        'lokasi',
        'kapasitas',
        'is_available',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'is_available' => 'boolean',
    ];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getSisaKapasitasAttribute()
    {
        return $this->kapasitas - $this->appointments()->count();
    }

    public function isFullyBooked()
    {
        return $this->appointments()->count() >= $this->kapasitas;
    }

    public function getCompletedCountAttribute()
    {
        return $this->appointments()->where('status', 'completed')->count();
    }

    public function getActiveCountAttribute()
    {
        return $this->appointments()
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();
    }
}