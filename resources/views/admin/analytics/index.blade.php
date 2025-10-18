@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">System Analytics</h2>

@if($events->count())
    <table class="table-auto w-full bg-white rounded-lg shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2">Seller</th>
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2">Event Type</th>
                <th class="px-4 py-2">Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $event->user->name ?? 'Guest' }}</td>
                    <td class="px-4 py-2">{{ $event->seller->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $event->product->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $event->event_type }}</td>
                    <td class="px-4 py-2">{{ $event->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $events->links() }}
    </div>
@else
    <p>No analytics data yet.</p>
@endif
@endsection
