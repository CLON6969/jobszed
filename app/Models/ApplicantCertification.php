<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantCertification extends Model
{
    protected $fillable = [
        'user_id', 'name', 'certification_type', 'issuing_organization',
        'registered_with_authority', 'registration_number', 'authority_certificate_path',
        'level', 'status', 'obtained_date'
    ];
}
