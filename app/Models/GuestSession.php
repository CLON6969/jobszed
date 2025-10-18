<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_token',
        'ip_address',
        'user_agent',
        'interactions',
        'expires_at',
    ];

    protected $casts = [
        'interactions' => 'array',
        'expires_at' => 'datetime',
    ];
}
