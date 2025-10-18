<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'=>'required|integer|min:1|max:5',
            'comment'=>'nullable|string|max:2000'
        ]);

        Review::create([
            'user_id'=>auth()->id() ?? null, // null for guest
            'product_id'=>$product->id,
            'rating'=>$request->rating,
            'comment'=>$request->comment,
            'approved'=>false, // guest reviews require admin approval
        ]);

        return back()->with('success','Review submitted for approval');
    }

    public function index()
    {
        $reviews = Review::with('product','user')->paginate(20);
        return view('customer.reviews.index', compact('reviews'));
    }
}
