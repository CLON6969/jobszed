<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcceptedDetail extends Model
{
    protected $fillable = ['job_post_id','start_date','position','salary','other_terms'];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}


