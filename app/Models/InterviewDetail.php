<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewDetail extends Model
{
    protected $fillable = ['job_post_id', 'type', 'date', 'time', 'venue', 'requirements'];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}


