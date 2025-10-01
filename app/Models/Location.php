<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['province', 'city'];

    // Relationship: One location has many applicant locations
    public function applicantLocations()
    {
        return $this->hasMany(ApplicantLocation::class);
    }
}
