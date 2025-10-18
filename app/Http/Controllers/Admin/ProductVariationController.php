<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariation;

class ProductVariationController extends Controller
{
    public function index()
    {
        $variations = ProductVariation::with('product')->paginate(20);
        return view('admin.variations.index', compact('variations'));
    }

    public function edit(ProductVariation $variation)
    {
        return view('admin.variations.edit', compact('variation'));
    }

    public function update(Request $request, ProductVariation $variation)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'option'=>'required|string|max:255',
            'price_adjustment'=>'nullable|numeric',
            'stock'=>'required|integer'
        ]);

        $variation->update($request->all());
        return redirect()->route('admin.productvariation.index')->with('success','Variation updated');
    }

    public function destroy(ProductVariation $variation)
    {
        $variation->delete();
        return redirect()->route('admin.productvariation.index')->with('success','Variation deleted');
    }
}
