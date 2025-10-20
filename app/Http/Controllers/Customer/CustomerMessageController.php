<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['product', 'receiver'])
            ->latest()
            ->get();

        return view('Customer.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        abort_unless(
            $message->sender_id === Auth::id() || $message->receiver_id === Auth::id(),
            403
        );

        $message->load(['sender', 'receiver', 'product']);
        return view('Customer.messages.show', compact('message'));
    }
}
