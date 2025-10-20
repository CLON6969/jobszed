@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
    
    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 text-blue-800 px-4 py-3 rounded mb-4">{{ session('info') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Product Details --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Images --}}
        <div class="space-y-2">
            @foreach($product->media as $media)
                <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded">
            @endforeach
        </div>

        {{-- Info & Actions --}}
        <div class="flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
                <p class="text-gray-600 mt-1">{{ $product->category?->name }}</p>
                <p class="text-blue-600 font-bold mt-4 text-xl">${{ number_format($product->price, 2) }}</p>
                <p class="mt-2">{{ $product->description }}</p>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-6 flex flex-col gap-2">
                @auth
                    {{-- Save / Unsave --}}
                    <form method="POST" action="{{ route('products.save', $product) }}">
                        @csrf
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                            {{ $isSaved ? 'Saved' : 'Save' }}
                        </button>
                    </form>

                    {{-- Review Form --}}
                    <form method="POST" action="{{ route('products.review', $product) }}" class="mt-4 border p-4 rounded space-y-2">
                        @csrf
                        <label class="block">Rating (1-5)</label>
                        <input type="number" name="rating" min="1" max="5" required class="border rounded px-2 py-1 w-20">
                        <label class="block">Comment</label>
                        <textarea name="comment" rows="3" class="border rounded w-full px-2 py-1"></textarea>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Submit Review</button>
                    </form>

                    {{-- Message Seller --}}
                    <form method="POST" action="{{ route('products.message', $product) }}" class="mt-4 border p-4 rounded space-y-2">
                        @csrf
                        <label class="block">Message Seller</label>
                        <textarea name="content" rows="3" required class="border rounded w-full px-2 py-1"></textarea>
                        <label class="block">Channel</label>
                        <select name="channel" required class="border rounded px-2 py-1 w-full">
                            <option value="whatsapp">WhatsApp</option>
                            <option value="email">Email</option>
                            <option value="facebook">Facebook</option>
                            <option value="messenger">Messenger</option>
                            <option value="telegram">Telegram</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Send Message</button>
                    </form>

                @else
                    <p class="text-red-600">Please <a href="{{ route('register') }}" class="underline">Sign Up</a> or <a href="{{ route('login') }}" class="underline">Login</a> to save, review or message the seller.</p>
                @endauth
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Reviews</h2>
        @forelse($product->reviews as $review)
            <div class="border rounded p-4 mb-2">
                <p class="font-semibold">{{ $review->user?->name ?? 'Guest' }} <span class="text-gray-500 text-sm">({{ $review->created_at->diffForHumans() }})</span></p>
                <p>Rating: {{ $review->rating }}/5</p>
                <p>{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-gray-600">No reviews yet.</p>
        @endforelse
    </div>

</div>
@endsection
