<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use App\Models\Message;
use App\Models\AnalyticsEvent;

class DashboardController extends Controller
{
    public function admin()
    {
        // Aggregate stats
        $totalUsers = User::count();
        $totalSellers = User::where('role_id', 3)->count();
        $totalCustomers = User::where('role_id', 4)->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalReviews = Review::count();
        $totalMessages = Message::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSellers',
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'totalReviews',
            'totalMessages'
        ));
    }

    // Job User Summary
    public function jobUserSummary()
    {
        $jobsPerUser = User::withCount('orders')->get();
        return view('admin.job_user_summary', compact('jobsPerUser'));
    }
}
