@extends('layouts.home')

@section('title', $product->name)

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
    <div class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-bounce">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-bounce">
        {{ session('error') }}
    </div>
@endif

<div class="container py-8 pt-20">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Media Gallery --}}
        <div>
            @if($product->media->count())
                <div class="mb-4 cursor-pointer" onclick="openLightbox(0)">
                    <img src="{{ asset('public/storage/' . $product->media->first()->file_path) }}"
                         class="rounded-lg shadow-md w-full h-96 object-cover transition-transform hover:scale-105">
                </div>

                <div class="flex gap-3 overflow-x-auto">
                    @foreach($product->media as $index => $media)
                        @if($media->media_type === 'image')
                            <img src="{{ asset('public/storage/' . $media->file_path) }}"
                                 class="h-20 w-20 object-cover rounded-md border cursor-pointer transition-transform hover:scale-110"
                                 onclick="openLightbox({{ $index }})" id="thumb-{{ $index }}">
                        @elseif($media->media_type === 'video')
                            <video class="h-20 w-28 rounded-md border cursor-pointer transition-transform hover:scale-110"
                                   onclick="openLightbox({{ $index }})">
                                <source src="{{ asset('public/storage/' . $media->file_path) }}" type="video/mp4">
                            </video>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="flex items-center justify-center h-96 bg-gray-100 rounded-lg">
                    <span class="text-gray-500">No media available</span>
                </div>
            @endif
        </div>

        {{-- Product Details --}}
        <div>
            <h1 class="text-2xl font-semibold mb-2">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
            <p class="text-blue-600 text-2xl font-bold mb-4">ZMW {{ number_format($product->price, 2) }}</p>

            <p class="text-gray-700 mb-4">{{ $product->description ?? 'No description provided.' }}</p>

            {{-- Variations --}}
            @if($product->variations->count())
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Available Variations</h3>
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach($product->variations as $var)
                            <li>
                                <strong>{{ $var->name }}</strong>: {{ $var->option ?? 'N/A' }} 
                                @if($var->price_adjustment)
                                    (+ZMW {{ number_format($var->price_adjustment, 2) }})
                                @endif — Stock: {{ $var->stock }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Location & Seller --}}
            <p class="text-gray-500 mb-2">📍 Location: {{ $product->location ?? 'N/A' }}</p>
            <p class="text-gray-500 mb-4">👤 Seller: {{ $product->seller->name ?? 'Unknown' }}</p>

            {{-- Save & Contact Buttons --}}
            <div class="flex gap-3 mb-6">
                @auth
                    <form action="{{ route('home.save', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition">
                            {{ $isSaved ? 'Saved ✓' : 'Save Product' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg transition">
                        Login to Save
                    </a>
                @endauth
            </div>

            {{-- Message Seller --}}
            <form id="myForm"  method="POST" action="{{ route('home.message', $product->id) }}" class="bg-gray-50 p-4 rounded-lg border" onsubmit="return handleWhatsApp(event)">
                @csrf

                <label class="block text-gray-700 mb-1">Message Seller:</label>
                <textarea name="content" id="messageContent" rows="3" class="w-full border-gray-300 rounded-lg mb-2 px-3 py-2"
                    placeholder="Type your message here..." required></textarea>

                <label class="block text-gray-700 mb-1">Choose Channel:</label>
<select name="channel" id="channelSelect"
    class="border-gray-300 rounded-lg w-full mb-3 px-3 py-2">
    <option value="whatsapp">WhatsApp</option>
    <option value="email">Email</option>
    @auth
        <option value="in_app">In-App Chat</option>
    @endauth
</select>


                {{-- Dynamic Email Fields --}}
                <div id="emailFields" class="hidden">
                    @guest
                        <div class="mb-3">
                            <label class="block text-gray-700 mb-1">Your Name:</label>
                            <input type="text" name="guest_name"
                                   class="border-gray-300 rounded-lg w-full px-3 py-2"
                                   placeholder="Enter your name">
                        </div>

                        <div class="mb-3">
                            <label class="block text-gray-700 mb-1">Your Email:</label>
                            <input type="email" name="guest_email"
                                   class="border-gray-300 rounded-lg w-full px-3 py-2"
                                   placeholder="Enter your email address">
                        </div>
                    @endguest
                    <p class="text-sm text-gray-500">📩 Your message will be sent directly to the seller's email.</p>
                </div>

                {{-- WhatsApp Note --}}
                <div id="whatsappNote" class="text-sm text-green-600 mb-3">
                    💬 You’ll be redirected to WhatsApp to chat directly with the seller.
                </div>



                

    <button type="submit" id="saveBtn"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg flex items-center shadow">
        <span class="btn-text"><i class="fas fa-save mr-2"></i> Save Changes</span>
        <span class="btn-loading hidden">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </span>
    </button>


            </form>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count())
        <div class="mt-12">
            <h2 class="text-xl font-semibold mb-4">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('home.show', $related->id) }}" class="block bg-white border rounded-lg overflow-hidden hover:shadow-md transition">
                        @if($related->media->count())
                            <img src="{{ asset('public/storage/' . $related->media->first()->file_path) }}"
                                 class="h-40 w-full object-cover transition-transform hover:scale-105">
                        @endif
                        <div class="p-3">
                            <p class="font-semibold truncate">{{ $related->name }}</p>
                            <p class="text-sm text-blue-600 font-bold">ZMW {{ number_format($related->price, 2) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- Modern Lightbox --}}
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-95 hidden items-center justify-center z-50 transition-opacity duration-300 p-4">
    <button class="absolute top-5 right-5 text-white text-3xl font-bold hover:text-gray-300 z-50" onclick="closeLightbox()">×</button>
    <button id="rotate-button"
        class="absolute top-5 right-16 text-white text-3xl font-bold hover:text-gray-300 z-50"
        onclick="rotateImage()">⟳</button>

    <button class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-5xl px-2 py-2 hover:text-gray-300 z-50" onclick="prevMedia()">‹</button>
    <div class="relative w-full h-full flex items-center justify-center">
        <img id="lightbox-image" class="max-h-full max-w-full object-contain rounded-lg shadow-2xl transition-transform duration-500 scale-90 hidden">
        <video id="lightbox-video" class="max-h-full max-w-full rounded-lg shadow-2xl hidden" controls autoplay></video>
    </div>
    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-5xl px-2 py-2 hover:text-gray-300 z-50" onclick="nextMedia()">›</button>
</div>

<script>
    // Toggle email/whatsapp fields
    const channelSelect = document.getElementById('channelSelect');
    const emailFields = document.getElementById('emailFields');
    const whatsappNote = document.getElementById('whatsappNote');

    channelSelect.addEventListener('change', function() {
        if (this.value === 'email') {
            emailFields.classList.remove('hidden');
            whatsappNote.classList.add('hidden');
        } else {
            emailFields.classList.add('hidden');
            whatsappNote.classList.remove('hidden');
        }
    });

    // WhatsApp handling for guests
    function handleWhatsApp(event) {
        const channel = channelSelect.value;
        if(channel === 'whatsapp') {
            event.preventDefault();
            const content = document.getElementById('messageContent').value;
            const sellerPhone = "{{ $product->seller->whatsapp }}";

            if(!sellerPhone) {
                alert('Seller has not provided a WhatsApp number.');
                return false;
            }

            const msgText = encodeURIComponent(`Hello, I'm interested in your product: {{ $product->name }}.\n\n${content}`);
            const whatsappUrl = `https://wa.me/${sellerPhone}?text=${msgText}`;
            window.open(whatsappUrl, '_blank');
            return false; // prevent form submission
        }
        return true; // submit form for email
    }

    // Lightbox functionality
    const mediaFiles = @json($product->media->map(fn($m) => ['path' => $m->file_path, 'type' => $m->media_type]));
    let currentIndex = 0;
    let currentRotation = 0;

    function openLightbox(index) {
        currentIndex = index;
        const media = mediaFiles[currentIndex];
        const img = document.getElementById('lightbox-image');
        const vid = document.getElementById('lightbox-video');
        const basePath = "{{ asset('public/storage') }}/";

        currentRotation = 0;
        img.style.transform = 'rotate(0deg) scale(1)';

        if (media.type === 'image') {
            img.src = basePath + media.path;
            img.classList.remove('hidden');
            vid.classList.add('hidden');
            vid.pause();
        } else {
            vid.src = basePath + media.path;
            vid.classList.remove('hidden');
            vid.play();
            img.classList.add('hidden');
        }

        document.getElementById('lightbox').classList.remove('hidden');
    }

    function closeLightbox() {
        const vid = document.getElementById('lightbox-video');
        vid.pause();
        vid.currentTime = 0;
        document.getElementById('lightbox').classList.add('hidden');
    }

    function nextMedia() {
        currentIndex = (currentIndex + 1) % mediaFiles.length;
        openLightbox(currentIndex);
    }

    function prevMedia() {
        currentIndex = (currentIndex - 1 + mediaFiles.length) % mediaFiles.length;
        openLightbox(currentIndex);
    }

    function rotateImage() {
        const img = document.getElementById('lightbox-image');
        if (img.classList.contains('hidden')) return;
        currentRotation = (currentRotation + 90) % 360;
        img.style.transform = `rotate(${currentRotation}deg)`;
    }
</script>

<script>
    setTimeout(() => {
        const messages = document.querySelectorAll('.fixed.top-5');
        messages.forEach(msg => msg.remove());
    }, 5000); // 5 seconds
</script>

    <script>
                // this is for the save button loading
document.getElementById('myForm').addEventListener('submit', function() {
    let btn = document.getElementById('saveBtn');
    btn.querySelector('.btn-text').classList.add('hidden');   // hide text
    btn.querySelector('.btn-loading').classList.remove('hidden'); // show spinner
    btn.disabled = true; // prevent double clicks
});
    </script>

@endsection
