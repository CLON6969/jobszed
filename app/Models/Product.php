<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'description',
        'price',
        'condition',
        'stock_quantity',
        'status',
        'delivery_available',
        'location',
    ];

    public function seller() { return $this->belongsTo(User::class, 'seller_id'); }
    public function category() { return $this->belongsTo(Category::class); }
    public function variations() { return $this->hasMany(ProductVariation::class); }
    public function media() { return $this->hasMany(ProductMedia::class); }
    public function reviews() { return $this->hasMany(Review::class); }

    protected static function booted()
{
    static::saving(function ($product) {
        if ($product->stock_quantity <= 0) {
            $product->status = 'sold';
        } elseif ($product->status === 'sold' && $product->stock_quantity > 0) {
            $product->status = 'active';
        }
    });
}

}
