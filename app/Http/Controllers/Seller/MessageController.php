<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
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

        return view('Seller.messages.index', compact('threads'));
    }

    public function show($customerId, $productId = null)
    {
        $sellerId = Auth::id();

        $messages = Message::between($sellerId, $customerId)
            ->when($productId, fn($q) => $q->where('product_id', $productId))
            ->with(['sender', 'receiver', 'replyTo'])
            ->orderBy('created_at', 'asc')
            ->get();

        $customer = User::findOrFail($customerId);
        $product = $productId ? Product::find($productId) : null;

        return view('Seller.messages.show', compact('messages', 'customer', 'product'));
    }

    public function send(Request $request, $customerId, $productId = null)
    {
        $request->validate([
            'content' => 'nullable|string|max:2000',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,pdf,doc,docx|max:20480',
            'reply_to_id' => 'nullable|exists:messages,id',
        ]);

        $sellerId = Auth::id();
        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $mediaPath = $media->store('messages', 'public');
            $mediaType = explode('/', $media->getMimeType())[0];
        }

        Message::create([
            'sender_id' => $sellerId,
            'receiver_id' => $customerId,
            'product_id' => $productId,
            'reply_to_id' => $request->reply_to_id,
            'content' => $request->content,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'channel' => 'in-app',
            'status' => 'sent',
        ]);

        return redirect()->route('Seller.messages.show', [$customerId, $productId])
                         ->with('success', 'Message sent successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['content' => 'required|string|max:2000']);

        $message = Message::where('id', $id)
            ->where('sender_id', Auth::id())
            ->firstOrFail();

        if ($message->created_at->diffInSeconds(now()) > 30) {
            return back()->withErrors(['edit' => 'You can only edit messages within 30 seconds of sending.']);
        }

        $message->update(['content' => $request->content . ' (edited)']);

        return back()->with('success', 'Message edited successfully.');
    }

    public function destroy($id)
    {
        $message = Message::where('id', $id)
            ->where('sender_id', Auth::id())
            ->firstOrFail();

        $message->update([
            'content' => 'This message was deleted',
            'is_deleted' => true,
        ]);

        return back()->with('success', 'Message marked as deleted.');
    }

    public function download($id)
    {
        $message = Message::findOrFail($id);

        if (!$message->media_path || !Storage::disk('public')->exists($message->media_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($message->media_path);
    }
}
