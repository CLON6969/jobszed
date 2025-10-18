@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Analytics for {{ $user->name }}</h2>

@if($events->count())
    <ul class="space-y-2">
        @foreach($events as $event)
            <li class="bg-white p-3 rounded shadow">
                <strong>{{ $event->event_type }}</strong> 
                on <em>{{ $event->product->name ?? 'N/A' }}</em> 
                by seller <em>{{ $event->seller->name ?? 'N/A' }}</em> 
                at {{ $event->created_at->format('d M Y H:i') }}
            </li>
        @endforeach
    </ul>
    <div class="mt-4">
        {{ $events->links() }}
    </div>
@else
    <p>No events recorded for this user.</p>
@endif
@endsection
