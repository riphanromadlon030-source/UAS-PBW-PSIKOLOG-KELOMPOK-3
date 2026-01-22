<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'starts_at',
        'link',
        'image',
        'poster',
        'is_published',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'is_published' => 'boolean',
    ];
}

