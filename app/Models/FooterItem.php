<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'url',
        'sort_order',
        'is_active',
        'footer_title_id'
    ];

    /**
     * Get the footer title that owns this item
     */
    public function title()
    {
        return $this->belongsTo(FooterTitle::class);
    }

    /**
     * Scope to get only active items
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

    /**
     * Get the full URL (with http:// if not present)
     */
    public function getFullUrlAttribute()
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $this->url)) {
            return "http://" . $this->url;
        }
        return $this->url;
    }
}

