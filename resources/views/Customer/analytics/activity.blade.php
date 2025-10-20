@extends('layouts.customer')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow rounded-xl p-6">
    <h2 class="text-2xl font-semibold mb-4">Activity Log</h2>

    @if($events->isEmpty())
        <p class="text-gray-600">No activity recorded yet.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($events as $event)
                <li class="py-2">
                    <p><strong>Type:</strong> {{ ucfirst($event->event_type) }}</p>
                    <p><strong>Product:</strong> {{ $event->product?->name ?? 'N/A' }}</p>
                    <p><strong>Details:</strong> {{ json_encode($event->event_data) }}</p>
                    <p><strong>IP:</strong> {{ $event->ip_address }}</p>
                    <p><strong>Time:</strong> {{ $event->created_at->format('M d, Y H:i') }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
