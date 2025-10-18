<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductVariationController extends Controller
{
    /**
     * Display a list of seller's products with the count of variations.
     */
    public function index()
    {
        $sellerId = Auth::id();

        $products = Product::where('seller_id', $sellerId)
            ->withCount('variations')
            ->latest()
            ->get(); // show all products; use paginate() if needed

        return view('Seller.product-variations.index', compact('products'));
    }

    /**
     * Show the form for creating a new variation.
     */
    public function create()
    {
        $sellerProducts = Product::where('seller_id', Auth::id())->get();

        return view('Seller.product-variations.create', compact('sellerProducts'));
    }

    /**
     * Store a newly created variation in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'option' => 'required|string|max:255',
            'price_adjustment' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::where('id', $validated['product_id'])
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        ProductVariation::create($validated);

        return redirect()->route('Seller.product-variations.index')
            ->with('success', 'Variation added successfully.');
    }

    /**
     * Display all variations for a specific product.
     */
    public function show($id)
    {
        $product = Product::with('variations')
            ->where('id', $id)
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        return view('Seller.product-variations.show', compact('product'));
    }

    /**
     * Show the form for editing the specified variation.
     */
    public function edit($id)
    {
        $variation = ProductVariation::where('id', $id)
            ->whereHas('product', fn($q) => $q->where('seller_id', Auth::id()))
            ->firstOrFail();

        return view('Seller.product-variations.edit', compact('variation'));
    }

    /**
     * Update the specified variation.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'option' => 'required|string|max:255',
            'price_adjustment' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
        ]);

        $variation = ProductVariation::where('id', $id)
            ->whereHas('product', fn($q) => $q->where('seller_id', Auth::id()))
            ->firstOrFail();

        $variation->update($validated);

        return redirect()->route('Seller.product-variations.index')
            ->with('success', 'Variation updated successfully.');
    }

    /**
     * Remove the specified variation.
     */
    public function destroy($id)
    {
        $variation = ProductVariation::where('id', $id)
            ->whereHas('product', fn($q) => $q->where('seller_id', Auth::id()))
            ->firstOrFail();

        $variation->delete();

        return redirect()->route('Seller.product-variations.index')
            ->with('success', 'Variation deleted successfully.');
    }
}
