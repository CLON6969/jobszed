<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerScheduleController extends Controller
{
    public function index()
    {
        $scheduled = Order::where('buyer_id', Auth::id())
            ->whereNotNull('scheduled_at')
            ->get();

        return view('Customer.schedule.index', compact('scheduled'));
    }

    public function store(Request $request, Order $order)
    {
        abort_unless($order->buyer_id === Auth::id(), 403);

        $request->validate([
            'scheduled_at' => 'required|date|after:now',
        ]);

        $order->update(['scheduled_at' => $request->scheduled_at]);

        return back()->with('success', 'Schedule updated!');
    }

    public function destroy(Order $order)
    {
        abort_unless($order->buyer_id === Auth::id(), 403);

        $order->update(['scheduled_at' => null]);

        return back()->with('success', 'Schedule canceled.');
    }
}
