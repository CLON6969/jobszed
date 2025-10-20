<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;

class GuestReviewController extends Controller
{
    public function guestStore(Request $request, $productId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'guest_name' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($productId);

        $review = Review::create([
            'user_id' => null,
            'product_id' => $productId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'approved' => false, // Requires admin review
        ]);

        AnalyticsEvent::create([
            'seller_id' => $product->seller_id,
            'product_id' => $productId,
            'event_type' => 'guest_review',
            'event_data' => [
                'guest_name' => $validated['guest_name'] ?? 'Anonymous',
                'rating' => $validated['rating'],
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json(['message' => 'Review submitted successfully. Pending moderation.']);
    }
}
