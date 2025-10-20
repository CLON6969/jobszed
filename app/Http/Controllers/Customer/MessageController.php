<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index()
    {
        $customerId = Auth::id();

        $threads = Message::where('sender_id', $customerId)
            ->orWhere('receiver_id', $customerId)
            ->with(['sender', 'receiver', 'product'])
            ->get()
            ->groupBy(function ($msg) use ($customerId) {
                $otherUser = $msg->sender_id === $customerId ? $msg->receiver_id : $msg->sender_id;
                return $otherUser . '_' . ($msg->product_id ?? 'none');
            });

        return view('Customer.messages.index', compact('threads'));
    }

    public function show($sellerId, $productId = null)
    {
        $customerId = Auth::id();

        $messages = Message::between($customerId, $sellerId)
            ->when($productId, fn($q) => $q->where('product_id', $productId))
            ->with(['sender', 'receiver', 'product'])
            ->orderBy('created_at', 'asc')
            ->get();

        $seller = User::findOrFail($sellerId);
        $product = $productId ? Product::find($productId) : null;

        return view('Customer.messages.show', compact('messages', 'seller', 'product'));
    }

    public function send(Request $request, $sellerId, $productId = null)
    {
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'media' => 'nullable|file|max:51200',
            'reply_to' => 'nullable|exists:messages,id',
        ]);

        $customerId = Auth::id();
        $metadata = [];

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('messages', 'public');
            $metadata['media'] = $path;
            $metadata['media_type'] = $file->getMimeType();
        }

        if ($request->filled('reply_to')) {
            $metadata['reply_to'] = $request->reply_to;
        }

        Message::create([
            'sender_id' => $customerId,
            'receiver_id' => $sellerId,
            'product_id' => $productId,
            'content' => $request->content ?? '',
            'channel' => 'in-app',
            'status' => 'sent',
            'metadata' => $metadata,
        ]);

        return redirect()->route('Customer.messages.show', [$sellerId, $productId])
                         ->with('success', 'Message sent successfully.');
    }

    public function edit($id)
    {
        $message = Message::where('id', $id)
            ->where('sender_id', Auth::id())
            ->firstOrFail();

        if ($message->created_at->diffInSeconds(now()) > 30) {
            return back()->withErrors(['edit' => 'You can only edit messages within 30 seconds of sending.']);
        }

        return view('Customer.messages.edit', compact('message'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['content' => 'required|string|max:1000']);

        $message = Message::where('id', $id)
            ->where('sender_id', Auth::id())
            ->firstOrFail();

        if ($message->created_at->diffInSeconds(now()) > 30) {
            return back()->withErrors(['edit' => 'Editing time window expired.']);
        }

        $message->update(['content' => $request->content . ' (edited)']);

        return redirect()->back()->with('success', 'Message edited successfully.');
    }

    public function destroy($id)
    {
        $message = Message::where('id', $id)
            ->where('sender_id', Auth::id())
            ->firstOrFail();

        $message->update(['content' => '', 'status' => 'deleted']);

        return back()->with('success', 'Message deleted.');
    }

    public function download($id)
    {
        $message = Message::findOrFail($id);

        if (!isset($message->metadata['media']) || !$message->metadata['media']) {
            abort(404, 'No media found.');
        }

        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return Storage::disk('public')->download($message->metadata['media']);
    }
}
