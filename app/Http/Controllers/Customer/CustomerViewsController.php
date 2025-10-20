<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Logo;
use App\Models\Review;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CustomerViewsController extends Controller
{
    /**
     * Display all available products to the public.
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Product::with(['category', 'media', 'seller', 'variations']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Show only active products by default
        if (!$request->filled('status')) {
            $query->where('status', 'active');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        $logo = Logo::latest()->first();

        return view('Customer.home.index', compact('products', 'logo', 'categories'));
    }

    /**
     * Show a single product with full details.
     */
    public function show($id)
    {
        $product = Product::with([
            'category',
            'media',
            'seller',
            'variations',
            'reviews.user',
        ])->findOrFail($id);

        $logo = Logo::latest()->first();

        $isSaved = Auth::check() 
            ? Auth::user()->savedProducts()->where('product_id', $product->id)->exists() 
            : false;

        $relatedProducts = Product::with('media')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('Customer.home.show', compact('product', 'logo', 'isSaved', 'relatedProducts'));
    }

    /**
     * Save or unsave a product for logged-in user.
     */
    public function save($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to save products.');
        }

        $user = Auth::user();
        $product = Product::findOrFail($id);

        if ($user->savedProducts()->where('product_id', $id)->exists()) {
            $user->savedProducts()->detach($id);
            return back()->with('success', 'Product removed from saved items.');
        } else {
            $user->savedProducts()->attach($id);
            return back()->with('success', 'Product saved successfully!');
        }
    }

    /**
     * Submit a product review.
     */
    public function review(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to leave a review.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'product_id' => $id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    /**
     * Message the product seller.
     */
   public function message(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string|max:500',
        'channel' => 'required|string|in:whatsapp,email',
        'guest_name' => 'nullable|string|max:100',
        'guest_email' => 'nullable|email|max:150',
    ]);

    $product = Product::with('seller')->findOrFail($id);
    $userLoggedIn = Auth::check();
    $senderId = $userLoggedIn ? Auth::id() : null;

    if ($request->channel === 'email') {
        $recipient = $product->seller->email;
        if (!$recipient) {
            return back()->with('error', 'Seller has not provided an email.');
        }

        // Guest info or logged-in info
        $guestName = $userLoggedIn ? Auth::user()->name : $request->guest_name;
        $guestEmail = $userLoggedIn ? Auth::user()->email : $request->guest_email;

        if (!$guestName || !$guestEmail) {
            return back()->with('error', 'Please provide your name and email to send the message.');
        }

        $emailData = [
            'product' => $product,
            'message' => $request->content,
            'guest_name' => $guestName,
            'guest_email' => $guestEmail,
        ];

        Mail::to($recipient)->send(new \App\Mail\MessageToSellerMail($emailData));

        // Only save to DB if user is logged in
        if ($userLoggedIn) {
            Message::create([
                'sender_id' => $senderId,
                'receiver_id' => $product->seller->id,
                'product_id' => $product->id,
                'content' => $request->content,
                'channel' => 'email',
                'status' => 'sent',
            ]);
        }

        return back()->with('success', 'Your message has been sent to the seller!');
    }

    // WhatsApp is handled in the Blade JS, so nothing happens here for guests
    return back()->with('error', 'Invalid message channel.');
}

}
