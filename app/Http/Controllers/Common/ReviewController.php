<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return response()->json(Review::with(['user', 'product'])->paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create($data);
        return response()->json($review, 201);
    }

    public function show(Review $review)
    {
        return response()->json($review->load(['user', 'product']));
    }

    public function update(Request $request, Review $review)
    {
        $review->update($request->all());
        return response()->json($review);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(['message' => 'Review deleted']);
    }
}
