<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::whereHas('product', fn($q)=>$q->where('seller_id', auth()->id()))->with('user','product')->paginate(20);
        return view('seller.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review->product);
        $review->delete();
        return back()->with('success','Review deleted');
    }
}
