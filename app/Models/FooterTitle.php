<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sort_order',
        'is_active'
    ];

    /**
     * Get all footer items for this title
     */
    public function items()
    {
        return $this->hasMany(FooterItem::class);
    }

    /**
     * Scope to get only active titles
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}

