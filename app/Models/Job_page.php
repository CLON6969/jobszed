<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_page extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'job_page';

    // Define the fillable fields (columns that can be mass-assigned)
    protected $fillable = [
        'background_picture',
        'title1',
        'title1_content',
        'button1_name',
        'button1_url',
        'button2_name',
        'button2_url',
        'title2',
    ];

    // Define any relationships if applicable (e.g., one-to-many, many-to-many, etc.)
    // Example: 
    // public function relatedModel()
    // {
    //     return $this->hasMany(RelatedModel::class);
    // }
}
