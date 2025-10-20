<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Message;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerProductController extends Controller
{
    /**
     * Display a list of products with optional filters.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with(['media', 'category', 'reviews']);

        // Apply filters if provided
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->paginate(12);

        return view('Customer.products.index', compact('products'));
    }

    /**
     * Display a single product with details and interactions.
     */
    public function show(Product $product)
    {
        $product->load(['media', 'category', 'reviews.user', 'variations']);

        // Check if user is logged in
        $user = Auth::user();
        $isSaved = $user ? $user->savedProducts()->where('product_id', $product->id)->exists() : false;

        return view('Customer.products.show', compact('product', 'user', 'isSaved'));
    }

    /**
     * Save a product to the logged-in customer's wishlist.
     */
    public function save(Product $product)
    {
        abort_unless(Auth::check(), 403);

        Auth::user()->savedProducts()->syncWithoutDetaching([$product->id]);
        return back()->with('success', 'Product saved!');
    }

    /**
     * Store a review for a product.
     */
    public function review(Request $request, Product $product)
    {
        abort_unless(Auth::check(), 403);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'approved' => false, // moderation workflow
        ]);

        return back()->with('success', 'Review submitted!');
    }

    /**
     * Send a message to the seller regarding a product.
     */
    public function message(Request $request, Product $product)
    {
        $request->validate([
            'content' => 'required|string',
            'channel' => 'required|string|in:whatsapp,email,facebook,messenger,telegram',
        ]);

        if (Auth::check()) {
            // Logged-in user sends message
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $product->seller_id,
                'product_id' => $product->id,
                'content' => $request->content,
                'channel' => $request->channel,
                'status' => 'pending',
            ]);

            return back()->with('success', 'Message sent to seller!');
        } else {
            // Guest users get redirected to signup/login
            return redirect()->route('register')->with('info', 'Please create an account to contact the seller.');
        }
    }
}
