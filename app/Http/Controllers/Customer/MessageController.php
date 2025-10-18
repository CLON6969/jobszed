<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'content'=>'required|string',
            'channel'=>'required|string|in:whatsapp,email',
        ]);

        $message = Message::create([
            'sender_id'=>auth()->id() ?? null, // null for guest
            'receiver_id'=>$product->seller_id,
            'product_id'=>$product->id,
            'content'=>$request->content,
            'channel'=>$request->channel,
            'status'=>'sent',
            'metadata'=>[],
        ]);

        // Optionally send via WhatsApp/email API here

        return back()->with('success','Message sent');
    }

    public function edit(Message $message)
    {
        $this->authorize('update',$message);

        // Only allow editing within 15 minutes
        if(Carbon::parse($message->created_at)->addMinutes(15)->lt(now())){
            return back()->with('error','Edit window expired');
        }

        return view('customer.messages.edit', compact('message'));
    }

    public function update(Request $request, Message $message)
    {
        $this->authorize('update',$message);

        $request->validate(['content'=>'required|string']);

        $message->update([
            'content'=>$request->content,
            'metadata'=>array_merge($message->metadata ?? [], ['edited_at'=>now()]),
        ]);

        return redirect()->back()->with('success','Message updated');
    }
}
