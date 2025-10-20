@extends('layouts.Customer')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow rounded-xl p-6">
    <h2 class="text-2xl font-semibold mb-4">Analytics Overview</h2>

    @if($analytics->isEmpty())
        <p class="text-gray-600">No analytics events recorded yet.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($analytics as $event)
                <li class="py-2">
                    <p><strong>Event Type:</strong> {{ ucfirst($event->event_type) }}</p>
                    <p><strong>Product:</strong> {{ $event->product?->name ?? 'N/A' }}</p>
                    <p><strong>Date:</strong> {{ $event->created_at->format('M d, Y H:i') }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
