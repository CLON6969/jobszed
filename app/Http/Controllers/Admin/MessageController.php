<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('sender','receiver','product')->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function edit(Message $message)
    {
        return view('admin.messages.edit', compact('message'));
    }

    public function update(Request $request, Message $message)
    {
        $request->validate(['content'=>'required|string']);
        $message->update(['content'=>$request->content]);
        return back()->with('success','Message updated');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with('success','Message deleted');
    }
}
