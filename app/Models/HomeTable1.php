<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeTable1 extends Model
{
    use HasFactory;

    protected $table = 'home_table1'; // explicitly defined because of the underscore

    protected $fillable = [
        'picture',
        'title1',
        'title1_content',
        'title1_small_text',
    ];
}
