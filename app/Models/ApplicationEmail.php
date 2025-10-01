<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'status',
        'email_content',
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }
}
