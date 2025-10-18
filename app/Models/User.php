<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'role_id',
        'onboarding_complete',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'email_verified' => 'boolean',
    ];

    // 🔗 Relationships
    public function role() { return $this->belongsTo(Role::class); }
    public function products() { return $this->hasMany(Product::class, 'seller_id'); }
    public function orders() { return $this->hasMany(Order::class, 'customer_id'); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function messages() { return $this->hasMany(Message::class, 'sender_id'); }
    public function subAccounts() { return $this->hasMany(User::class, 'parent_account_id'); }

    // 🧠 Role helpers
    public function isAdmin(): bool { return $this->role?->name === 'admin'; }
    public function isSeller(): bool { return $this->role?->name === 'seller'; }
    public function isCustomer(): bool { return $this->role?->name === 'customer'; }
}


