<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicantLocation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'location_id'];

    // Relationship: This belongs to a Location
// In App\Models\ApplicantLocation.php

public function location()
{
    return $this->belongsTo(Location::class);
}


    // Relationship: This belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
