<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return response()->json(Message::latest()->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'content' => 'required|string',
            'channel' => 'required|string|in:whatsapp,email',
            'status' => 'nullable|string',
        ]);

        $message = Message::create($data);
        return response()->json($message, 201);
    }

    public function show(Message $message)
    {
        return response()->json($message->load(['sender', 'receiver', 'product']));
    }

    public function update(Request $request, Message $message)
    {
        $message->update($request->all());
        return response()->json($message);
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json(['message' => 'Message deleted']);
    }
}
