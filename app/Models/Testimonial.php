<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'content',
        'rating',
        'service_type',
        'avatar',
        'image',
        'is_approved',
        'psychologist_id',
        'user_id',
        'admin_notes',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];
    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}