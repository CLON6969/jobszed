<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoluntaryDisclosure extends Model
{
    protected $fillable = [
        'user_id', 'disability_status', 'ethnicity', 'gender_identity', 'is_veteran'
    ];
}
