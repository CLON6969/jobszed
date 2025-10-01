<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_post_id',
        'cover_letter',
        'cv',
        'answers',
        'status',
        'submitted_at',
        'status_notes',
        // Optional fields for interview emails
        'interview_type',
        'interview_date',
        'interview_time',
        'interview_venue',
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted_at' => 'datetime',
    ];

    // -------------------------------
    // Relationships
    // -------------------------------

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }

  

    // -------------------------------
    // Detail Relationships
    // -------------------------------

    public function interviewDetail()
    {
        return $this->hasOne(\App\Models\InterviewDetail::class, 'job_post_id');
    }

    public function shortlistedDetail()
    {
        return $this->hasOne(\App\Models\ShortlistedDetail::class, 'job_post_id');
    }

    public function rejectedDetail()
    {
        return $this->hasOne(\App\Models\RejectedDetail::class, 'job_post_id');
    }

    public function acceptedDetail()
    {
        return $this->hasOne(\App\Models\AcceptedDetail::class, 'job_post_id');
    }

    // -------------------------------
    // Helper Methods
    // -------------------------------

    /**
     * Get email template content for a given type
     */
    public function getEmailTemplate(string $type)
    {
        return \App\Models\EmailTemplate::where('type', $type)->first();
    }

    /**
     * Eager load all details and user/jobPost for Mailables
     */
    public function scopeWithAllDetails($query)
    {
        return $query->with([
            'user',
            'jobPost',
            'interviewDetail',
            'shortlistedDetail',
            'rejectedDetail',
            'acceptedDetail'
        ]);
    }
}
  
