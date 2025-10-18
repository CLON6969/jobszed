<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('user.messages.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $data['sender_id'] = Auth::id();
        Message::create($data);

        return redirect()->back()->with('success', 'Message sent.');
    }
}
