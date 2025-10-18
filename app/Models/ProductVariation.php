<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'option',
        'price_adjustment',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Automatically sync product total stock when variation is saved or deleted
    protected static function booted()
    {
        static::saved(function ($variation) {
            $variation->syncProductStock();
        });

        static::deleted(function ($variation) {
            $variation->syncProductStock();
        });
    }

    protected function syncProductStock()
    {
        $product = $this->product;
        if (!$product) return;

        $totalStock = $product->variations()->sum('stock');
        $product->stock_quantity = $totalStock;

        // Automatically update product status
        if ($totalStock <= 0) {
            $product->status = 'sold';
        } elseif ($product->status === 'sold' && $totalStock > 0) {
            $product->status = 'active';
        }

        $product->saveQuietly(); // Quietly avoids recursion/trigger loops
    }
}
