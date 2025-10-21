@extends('layouts.Seller')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h1>
        <p class="text-gray-500 mt-1">Product Performance Overview</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm mb-1">Total Sales</h4>
            <p class="text-2xl font-semibold text-green-600">K{{ number_format($productSales, 2) }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm mb-1">Total Orders</h4>
            <p class="text-2xl font-semibold text-blue-600">{{ $productOrders }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm mb-1">Avg Rating</h4>
            <p class="text-2xl font-semibold text-yellow-500">
                {{ number_format($averageRating ?? 0, 1) }} ★
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm mb-1">Total Reviews</h4>
            <p class="text-2xl font-semibold text-purple-600">{{ $totalReviews }}</p>
        </div>
    </div>

    <!-- Monthly Sales Trend -->
    <div class="bg-white p-6 rounded-xl shadow border border-gray-100 mb-10">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Monthly Sales Trend</h3>
        @if($monthlySales->count())
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border-b">Month</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border-b">Year</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border-b">Orders</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600 border-b">Sales (K)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlySales as $sale)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::create()->month($sale->month)->format('F') }}</td>
                                <td class="px-4 py-2 border-b">{{ $sale->year }}</td>
                                <td class="px-4 py-2 border-b">{{ $sale->orders_count }}</td>
                                <td class="px-4 py-2 border-b text-green-600 font-semibold">
                                    K{{ number_format($sale->total_sales, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No sales data available for this product.</p>
        @endif
    </div>

    <!-- Recent Reviews -->
    <div class="bg-white p-6 rounded-xl shadow border border-gray-100">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Recent Reviews</h3>
        @if($product->reviews->count())
            <ul class="divide-y divide-gray-200">
                @foreach($product->reviews as $review)
                    <li class="py-3">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-semibold text-gray-800">{{ $review->user->name ?? 'Anonymous' }}</span>
                            <span class="text-yellow-500 text-sm">{{ str_repeat('★', $review->rating) }}</span>
                        </div>
                        <p class="text-gray-600 text-sm">{{ $review->comment }}</p>
                        <span class="text-gray-400 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No reviews yet for this product.</p>
        @endif
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('Seller.analytics.index') }}" 
           class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            ← Back to Analytics Dashboard
        </a>
    </div>
</div>
@endsection
