<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MessageController extends Controller
{
    /**
     * Display chat threads grouped by customer and product.
     */
    public function index()
    {
        $sellerId = Auth::id();

        $threads = Message::where('receiver_id', $sellerId)
            ->orWhere('sender_id', $sellerId)
            ->with(['sender', 'receiver', 'product'])
            ->get()
            ->groupBy(function ($msg) use ($sellerId) {
                $otherUser = $msg->sender_id === $sellerId ? $msg->receiver_id : $msg->sender_id;
                return $otherUser . '_' . ($msg->product_id ?? 'none');
            });

        return view('seller.messages.index', compact('threads'));
    }

    /**
     * Show a single conversation thread.
     */
    public function show($customerId, $productId = null)
    {
        $sellerId = Auth::id();

        $messages = Message::where(function ($q) use ($sellerId, $customerId) {
                $q->where('sender_id', $sellerId)->where('receiver_id', $customerId);
            })
            ->orWhere(function ($q) use ($sellerId, $customerId) {
                $q->where('sender_id', $customerId)->where('receiver_id', $sellerId);
            })
            ->when($productId, fn($q) => $q->where('product_id', $productId))
            ->with(['sender', 'receiver', 'product'])
            ->orderBy('created_at', 'asc')
            ->get();

        $customer = User::findOrFail($customerId);
        $product = $productId ? Product::find($productId) : null;

        return view('seller.messages.show', compact('messages', 'customer', 'product'));
    }

    /**
     * Send a new message.
     */
    public function send(Request $request, $customerId, $productId = null)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $sellerId = Auth::id();

        Message::create([
            'sender_id'   => $sellerId,
            'receiver_id' => $customerId,
            'product_id'  => $productId,
            'content'     => $request->content,
            'channel'     => 'in-app',
            'status'      => 'sent',
        ]);

        return redirect()->route('seller.messages.show', [$customerId, $productId])
                         ->with('success', 'Message sent successfully.');
    }

    /**
     * Edit a message (only within a limited time window).
     */
    public function edit($id)
    {
        $message = Message::where('id', $id)
            ->where('sender_id', Auth::id())
            ->firstOrFail();

        // Check 15-minute edit limit
        if ($message->created_at->diffInMinutes(now()) > 15) {
            return back()->withErrors(['edit' => 'You can only edit messages within 15 minutes of sending.']);
        }

        return view('seller.messages.edit', compact('message'));
    }

    /**
     * Update the edited message content.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::where('id', $id)
            ->where('sender_id', Auth::id())
            ->firstOrFail();

        if ($message->created_at->diffInMinutes(now()) > 15) {
            return back()->withErrors(['edit' => 'Editing time window expired.']);
        }

        $message->update([
            'content' => $request->content . ' (edited)',
        ]);

        return redirect()->back()->with('success', 'Message edited successfully.');
    }
}
