<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_post_id',
        'question',
        'required',
    ];

    protected $casts = [
        'required' => 'boolean',
    ];

    /**
     * Get the job post this question is associated with.
     */
    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }
}
