<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortlistedDetail extends Model
{
    protected $fillable = ['job_post_id','notes'];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}


