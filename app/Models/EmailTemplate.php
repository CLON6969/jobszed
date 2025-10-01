<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',      // e.g. shortlisted, rejected, interview, accepted
        'subject',
        'body',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
