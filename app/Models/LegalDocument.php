<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model {
    protected $fillable = ['title', 'slug', 'is_active'];

    public function sections() {
        return $this->hasMany(LegalSection::class);
    }
}

