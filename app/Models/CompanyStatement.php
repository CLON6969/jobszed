<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyStatement extends Model
{
    use HasFactory;

    // Table name (optional, if it matches the plural form)
    protected $table = 'company_statements';

    // The attributes that are mass assignable.
    protected $fillable = [
        'title1',
        'title1_main_content', // Note: Typo in migration ('tittle1_main_content' vs 'title1_main_content')
        'title1_sub_content',
        'background_picture',
    ];
}
