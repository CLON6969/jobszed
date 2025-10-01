<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantProfile extends Model
{
    protected $fillable = [
        'user_id', 'recruitment_status', 'national_id', 'date_of_birth', 'gender',
        'nationality', 'address', 'postal_code', 'linkedin_url', 'professional_summary',
        'years_of_experience'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

