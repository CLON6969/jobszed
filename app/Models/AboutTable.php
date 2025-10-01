<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutTable extends Model
{
    use HasFactory;

    protected $table = 'about_table'; // explicitly defined because of the underscore

    protected $fillable = [
        'picture',
        'title1',
        'title1_content',
        'title1_small_text',
    ];
}
