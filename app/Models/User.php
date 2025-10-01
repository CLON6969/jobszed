<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
 use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_type',
        'name',
        'username',
        'email',
        'password',
        'profile_picture',
        'account_status',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'website',
        'two_factor_enabled',
        'email_verified',
        'bio',
        'job_title',
        'referral_source',
        'parent_account_id',
        'account_type',
        'email_verified_at',
        'role_id',
        'onboarding_complete',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'email_verified' => 'boolean',
        'profile_completed' => 'boolean',
    ];

    /**
     * Relationships
     */
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function parentAccount()
    {
        return $this->belongsTo(User::class, 'parent_account_id');
    }

    public function subAccounts()
    {
        return $this->hasMany(User::class, 'parent_account_id');
    }

   
public function profile()
{
    return $this->hasOne(ApplicantProfile::class);
}

public function experiences()
{
    return $this->hasMany(Experience::class);
}

public function educations()
{
    return $this->hasMany(Education::class);
}

public function certifications()
{
    return $this->hasMany(ApplicantCertification::class);
}

public function voluntaryDisclosure()
{
    return $this->hasOne(VoluntaryDisclosure::class);
}

public function applicantProfile()
{
    return $this->hasOne(\App\Models\ApplicantProfile::class);
}

// User.php







public function voluntaryDisclosures()
{
    return $this->hasOne(VoluntaryDisclosure::class);
}

// in User.php
public function isAdmin()
{
    return $this->role_id === 1; // or whatever you use
}

public function isEmployer()
{
    return $this->role_id === 3;
}




    
}



