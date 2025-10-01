<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    protected $table = 'home'; // explicitly define table name if singular

    protected $fillable = [
        'title1',
        'title1_content',
        'title1_sub_content',
        'title2',
        'title2_content',
        'title3',
        'title3_content',
        'title3_sub_content',
        'title4',
        'title4_content',
        'title4_sub_content',
        'button1_name',
        'button1_url',
        'button2_name',
        'button2_url',
        'button3_name',
        'button3_url',
        'button4_name',
        'button4_url',
        'background_picture',
        'background_picture2',
    ];
}
