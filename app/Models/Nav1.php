<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav1 extends Model
{
    protected $table = 'nav1';
    protected $fillable = ['name', 'name_url', 'parent_id'];

    // Relation: parent
    public function parent()
    {
        return $this->belongsTo(Nav1::class, 'parent_id');
    }

    // Relation: children
    public function children()
    {
        return $this->hasMany(Nav1::class, 'parent_id');
    }
}
