<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'psychologist_id',
        'counselor_id',
        'day',
        'start_time',
        'end_time',
        'is_available',
    ];

    protected $casts = [
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
}