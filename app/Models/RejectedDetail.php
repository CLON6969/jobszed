<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectedDetail extends Model
{
    protected $fillable = ['job_post_id','reason'];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}
