<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'responsibilities', 'benefits',
        'employment_type', 'work_setup', 'location', 'country', 'department',
        'level', 'salary_range', 'application_deadline', 'status', 'posted_by',
    ];

    protected $casts = [
        'application_deadline' => 'date',
    ];

    // Relationships
    public function skills() { return $this->hasMany(JobSkill::class); }
    public function experiences() { return $this->hasMany(JobExperience::class); }
    public function qualifications() { return $this->hasMany(JobQualification::class); }
    public function questions() { return $this->hasMany(JobQuestion::class); }
    public function applications(): HasMany { return $this->hasMany(JobApplication::class, 'job_post_id'); }
    public function user() { return $this->belongsTo(User::class, 'posted_by'); }

    // Shared response details (general to the job)
    public function shortlistedDetail() { return $this->hasOne(ShortlistedDetail::class, 'job_post_id'); }
    public function rejectedDetail() { return $this->hasOne(RejectedDetail::class, 'job_post_id'); }
    public function interviewDetail() { return $this->hasOne(InterviewDetail::class, 'job_post_id'); }
    public function acceptedDetail() { return $this->hasOne(AcceptedDetail::class, 'job_post_id'); }
}

