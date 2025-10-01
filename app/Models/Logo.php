<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $table = 'logo'; // explicitly defined because of the underscore

    protected $fillable = [
        'picture',
         'picture2',
        'title',
        'home_url',
        'background_picture'
    ];
}
