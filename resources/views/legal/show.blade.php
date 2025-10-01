@extends('layouts.legal')

@section('title', $document->title)

@section('content')
<div class="container py-5">
    <h1>{{ $document->title }}</h1>

    @foreach ($document->sections->sortBy('order') as $section)
        <h2>{{ $section->heading }}</h2>

        @if ($section->body)
            <p>{{ $section->body }}</p>
        @endif

        @if ($section->listItems->count())
            <ul>
                @foreach ($section->listItems->sortBy('order') as $item)
                    <li>{{ $item->item_text }}</li>
                @endforeach
            </ul>
        @endif
    @endforeach
</div>
@endsection
