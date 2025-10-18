<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductVariationController extends Controller
{
    /**
     * Display a listing of the product variations.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id !== 3) {
            abort(403, 'Unauthorized');
        }

        $variations = ProductVariation::whereHas('product', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('product')->latest()->paginate(10);

        return view('user.Seller.product_variations.index', compact('variations'));
    }

    /**
     * Show the form for creating a new variation.
     */
    public function create()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();

        return view('user.Seller.product_variations.create', compact('products'));
    }

    /**
     * Store a newly created variation.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:100',
            'option' => 'nullable|string|max:100',
            'price_adjustment' => 'nullable|numeric',
            'stock' => 'nullable|integer',
        ]);

        ProductVariation::create($data);

        return redirect()->route('user.Seller.product-variations.index')
            ->with('success', 'Product variation created successfully.');
    }

    /**
     * Show a specific variation.
     */
    public function show(ProductVariation $productVariation)
    {
        $this->authorizeAccess($productVariation);
        return view('user.Seller.product_variations.show', compact('productVariation'));
    }

    /**
     * Show edit form.
     */
    public function edit(ProductVariation $productVariation)
    {
        $this->authorizeAccess($productVariation);
        $products = Product::where('user_id', Auth::id())->get();
        return view('user.Seller.product_variations.edit', compact('productVariation', 'products'));
    }

    /**
     * Update the variation.
     */
    public function update(Request $request, ProductVariation $productVariation)
    {
        $this->authorizeAccess($productVariation);

        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:100',
            'option' => 'nullable|string|max:100',
            'price_adjustment' => 'nullable|numeric',
            'stock' => 'nullable|integer',
        ]);

        $productVariation->update($data);

        return redirect()->route('user.Seller.product-variations.index')
            ->with('success', 'Variation updated successfully.');
    }

    /**
     * Delete the variation.
     */
    public function destroy(ProductVariation $productVariation)
    {
        $this->authorizeAccess($productVariation);
        $productVariation->delete();

        return redirect()->route('user.Seller.product-variations.index')
            ->with('success', 'Variation deleted successfully.');
    }

    /**
     * Helper to prevent unauthorized access.
     */
    private function authorizeAccess(ProductVariation $variation)
    {
        if ($variation->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
    }
}
