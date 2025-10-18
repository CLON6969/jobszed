@extends('layouts.seller')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Analytics Dashboard</h1>
    <p class="text-gray-600">Monitor your performance and insights in real time.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Sales -->
    <div class="bg-white shadow rounded-lg p-5 text-center">
        <h2 class="text-gray-500 text-sm mb-2">Total Sales</h2>
        <p class="text-2xl font-semibold text-green-600">K{{ number_format($totalSales, 2) }}</p>
    </div>

    <!-- Total Orders -->
    <div class="bg-white shadow rounded-lg p-5 text-center">
        <h2 class="text-gray-500 text-sm mb-2">Total Orders</h2>
        <p class="text-2xl font-semibold text-blue-600">{{ $totalOrders }}</p>
    </div>

    <!-- Total Reviews -->
    <div class="bg-white shadow rounded-lg p-5 text-center">
        <h2 class="text-gray-500 text-sm mb-2">Total Reviews</h2>
        <p class="text-2xl font-semibold text-yellow-600">{{ $totalReviews }}</p>
    </div>

    <!-- Products Active -->
    <div class="bg-white shadow rounded-lg p-5 text-center">
        <h2 class="text-gray-500 text-sm mb-2">Active Products</h2>
        <p class="text-2xl font-semibold text-indigo-600">{{ $activeProducts }}</p>
    </div>
</div>

<!-- Sales Trend Chart -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-lg font-semibold mb-4">Sales Trend (Last 30 Days)</h2>
    @if($salesDates->count() > 0)
        <canvas id="salesChart"></canvas>
    @else
        <p class="text-gray-500 text-center py-8">No sales data available for the last 30 days.</p>
    @endif
</div>

<!-- Top Products -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Top Performing Products</h2>
        <span class="text-sm text-gray-500">Last 30 days</span>
    </div>

    @if($topProducts->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border">
                <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                    <tr>
                        <th class="p-3 font-medium">Product</th>
                        <th class="p-3 font-medium">Price</th>
                        <th class="p-3 font-medium">Orders</th>
                        <th class="p-3 font-medium">Revenue</th>
                        <th class="p-3 font-medium">Rating</th>
                        <th class="p-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $product)
                        <tr class="border-t hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-medium">{{ $product->name }}</td>
                            <td class="p-3">K{{ number_format($product->price, 2) }}</td>
                            <td class="p-3">{{ $product->orders_count }}</td>
                            <td class="p-3">K{{ number_format($product->total_revenue, 2) }}</td>
                            <td class="p-3">
                                @if($product->reviews_avg_rating)
                                    {{ number_format($product->reviews_avg_rating, 1) }} ⭐
                                @else
                                    <span class="text-gray-400">No reviews</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <a href="{{ route('Seller.analytics.show', $product->id) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8">
            <div class="text-gray-400 mb-2">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <p class="text-gray-600">No analytics data available yet.</p>
            <p class="text-gray-500 text-sm mt-1">Start selling to see your performance metrics.</p>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($salesDates->count() > 0)
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesDates),
            datasets: [{
                label: 'Sales (ZMW)',
                data: @json($salesAmounts),
                borderColor: '#16a34a',
                backgroundColor: 'rgba(22,163,74,0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'K' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Sales: K' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });
@endif
</script>
@endpush