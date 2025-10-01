<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $table = 'socials';

    protected $fillable = [
        'icon',
        'name_url', 
        'sort_order',
        'is_active'
    ];
}


