<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'message', 'is_read', 'admin_reply', 'replied_at'];

    protected $casts = [
        'replied_at' => 'datetime',
        'is_read' => 'boolean',
    ];
}