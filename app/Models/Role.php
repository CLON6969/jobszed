<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    // 🔹 Optional: See all users with this role
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
