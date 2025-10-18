<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id();

        // Total Sales
        $totalSales = Order::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->sum('total_amount');

        // Total Orders
        $totalOrders = Order::where('seller_id', $sellerId)->count();

        // Total Reviews
        $totalReviews = Review::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->count();

        // Active Products
        $activeProducts = Product::where('seller_id', $sellerId)->count();

        // Sales Trend - Last 30 Days
        $salesTrend = Order::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total_sales'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $salesDates = $salesTrend->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M j'));
        $salesAmounts = $salesTrend->pluck('total_sales');

        // Top Performing Products
        $topProducts = Product::where('products.seller_id', $sellerId)
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', function ($join) use ($sellerId) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where('orders.seller_id', $sellerId)
                    ->where('orders.status', 'completed');
            })
            ->select(
                'products.id',
                'products.name',
                'products.price',
                DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
                DB::raw('COALESCE(SUM(order_items.subtotal), 0) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->withAvg('reviews', 'rating')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        return view('Seller.analytics.index', compact(
            'totalSales',
            'totalOrders',
            'totalReviews',
            'activeProducts',
            'salesDates',
            'salesAmounts',
            'topProducts'
        ));
    }

    /**
     * Show detailed analytics for a specific product
     */
    public function show($productId)
    {
        $sellerId = auth()->id();

        $product = Product::where('seller_id', $sellerId)
            ->with([
                'orderItems.order' => function ($query) {
                    $query->where('status', 'completed');
                },
                'reviews.user'
            ])
            ->findOrFail($productId);

        // Product stats
        $productSales = $product->orderItems
            ->where('order.status', 'completed')
            ->sum('subtotal');

        $productOrders = $product->orderItems
            ->where('order.status', 'completed')
            ->groupBy('order_id')
            ->count();

        $averageRating = $product->reviews->avg('rating');
        $totalReviews = $product->reviews->count();

        // Monthly Sales Trend
        $monthlySales = OrderItem::where('product_id', $productId)
            ->whereHas('order', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId)
                    ->where('status', 'completed');
            })
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('SUM(order_items.subtotal) as total_sales'),
                DB::raw('COUNT(DISTINCT orders.id) as orders_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Recent Orders for this product
        $recentOrders = OrderItem::where('product_id', $productId)
            ->whereHas('order', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId)
                  ->where('status', 'completed');
            })
            ->with('order.customer')
            ->latest('order_items.created_at')
            ->take(10)
            ->get();

        return view('Seller.analytics.show', compact(
            'product',
            'productSales',
            'productOrders',
            'averageRating',
            'totalReviews',
            'monthlySales',
            'recentOrders'
        ));
    }

    /**
     * Show all seller orders for analytics
     */
    public function orders()
    {
        $sellerId = auth()->id();

        $orders = Order::where('seller_id', $sellerId)
            ->with(['customer', 'items.product'])
            ->latest()
            ->paginate(20);

        return view('Seller.analytics.orders', compact('orders'));
    }

    /**
     * Show all analytics events
     */
    public function events()
    {
        $events = AnalyticsEvent::where('seller_id', auth()->id())
            ->with('user', 'product')
            ->latest()
            ->paginate(50);

        return view('Seller.analytics.events', compact('events'));
    }
}
