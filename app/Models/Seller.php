<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_logo',
        'verification_status',
        'whatsapp_number',
        'email',
        'address',
        'city',
        'state',
        'country',
        'bio',
        'website',
        'approved_by_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function analytics()
    {
        return $this->hasMany(AnalyticsEvent::class);
    }
}


