<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use Illuminate\Support\Facades\Auth;

class CustomerAnalyticsController extends Controller
{
    public function index()
    {
        $analytics = AnalyticsEvent::where('user_id', Auth::id())->latest()->get();
        return view('Customer.analytics.index', compact('analytics'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->with('items')->get();
        return view('Customer.analytics.orders', compact('orders'));
    }

    public function spending()
    {
        $totalSpent = Auth::user()->orders()->sum('total_amount');
        return view('Customer.analytics.spending', compact('totalSpent'));
    }

    public function activity()
    {
        $events = AnalyticsEvent::where('user_id', Auth::id())->latest()->get();
        return view('Customer.analytics.activity', compact('events'));
    }
}
