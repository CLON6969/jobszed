@extends('layouts.seller')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Product</h1>

    {{-- Inline error alert --}}
    @if ($errors->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ $errors->first('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form id="productForm" action="{{ route('Seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- PRODUCT INFORMATION --}}
        <h2 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-700">Product Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-600 mb-1 font-medium">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm p-3" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Category</label>
                <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm p-3" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border-gray-300 rounded-lg shadow-sm p-3" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Total Stock Quantity</label>
                <input 
                    type="number" 
                    id="productStock" 
                    readonly 
                    value="{{ $product->stock_quantity }}" 
                    class="w-full border-gray-300 rounded-lg shadow-sm p-3 bg-gray-100 cursor-not-allowed" 
                >
                <p class="text-gray-500 text-sm mt-1">Automatically calculated from product variations.</p>
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Condition</label>
                <select name="condition" class="w-full border-gray-300 rounded-lg shadow-sm p-3">
                    <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                    <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Delivery Available</label>
                <select name="delivery_available" class="w-full border-gray-300 rounded-lg shadow-sm p-3">
                    <option value="1" {{ old('delivery_available', $product->delivery_available) ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !old('delivery_available', $product->delivery_available) ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-600 mb-1 font-medium">Location</label>
                <input type="text" name="location" value="{{ old('location', $product->location) }}" class="w-full border-gray-300 rounded-lg shadow-sm p-3">
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-600 mb-1 font-medium">Description</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm p-3">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        {{-- EXISTING MEDIA --}}
        <h2 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-700">Existing Media</h2>
        <div class="flex flex-wrap gap-4 mb-6">
            @foreach($product->media as $media)
                <div class="relative">
                    @if($media->media_type === 'video')
                        <video src="{{ asset('public/storage/' . $media->file_path) }}" class="w-32 h-32 object-cover rounded-lg" controls></video>
                    @else
                        <img src="{{ asset('public/storage/' . $media->file_path) }}" class="w-32 h-32 object-cover rounded-lg">
                    @endif
                    <div class="absolute top-1 right-1 flex gap-1">
                        <label class="bg-yellow-500 text-white text-xs px-2 py-1 rounded cursor-pointer">
                            <input type="radio" name="primary_existing" value="{{ $media->id }}" {{ $media->is_primary ? 'checked' : '' }}> Primary
                        </label>
                        <label class="bg-red-500 text-white text-xs px-2 py-1 rounded cursor-pointer">
                            <input type="checkbox" name="remove_media[]" value="{{ $media->id }}"> Delete
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- NEW MEDIA UPLOAD --}}
        <h2 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-700">Add New Media</h2>
        <div class="mb-6">
            <label class="block text-gray-600 mb-2 font-medium">Upload Images/Videos</label>
            <input id="mediaInput" type="file" name="media[]" multiple accept="image/*,video/*" class="hidden">
            <div id="mediaPreview" class="flex flex-wrap gap-4 border-2 border-dashed border-gray-300 p-4 rounded-lg justify-center cursor-pointer" onclick="document.getElementById('mediaInput').click()">
                <p class="text-gray-500 text-center w-full">Click or Drop Files to Upload</p>
            </div>
        </div>

        {{-- VARIATIONS --}}
        <h2 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-700">Product Variations</h2>
        <div id="variation-section">
            @foreach($product->variations as $i => $var)
                <div class="variation-group mb-4 border rounded p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" name="variations[{{ $i }}][name]" value="{{ $var->name }}" placeholder="Variation Name" class="border rounded p-2">
                        <input type="text" name="variations[{{ $i }}][option]" value="{{ $var->option }}" placeholder="Option" class="border rounded p-2">
                        <input type="number" step="0.01" name="variations[{{ $i }}][price_adjustment]" value="{{ $var->price_adjustment }}" placeholder="Price Adjustment" class="border rounded p-2">
                        <input type="number" name="variations[{{ $i }}][stock]" value="{{ $var->stock }}" placeholder="Stock" class="border rounded p-2 variation-stock">
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-variation" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mb-6">+ Add Variation</button>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('Seller.products.index') }}" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">Cancel</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">Update Product</button>
        </div>
    </form>
</div>

<script>
let variationCount = {{ count($product->variations) }};

// Add variation dynamically
document.getElementById('add-variation').addEventListener('click', () => {
    const section = document.getElementById('variation-section');
    const html = `
    <div class="variation-group mb-4 border rounded p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="variations[${variationCount}][name]" placeholder="Variation Name" class="border rounded p-2">
            <input type="text" name="variations[${variationCount}][option]" placeholder="Option" class="border rounded p-2">
            <input type="number" step="0.01" name="variations[${variationCount}][price_adjustment]" placeholder="Price Adjustment" class="border rounded p-2">
            <input type="number" name="variations[${variationCount}][stock]" placeholder="Stock" class="border rounded p-2 variation-stock">
        </div>
    </div>`;
    section.insertAdjacentHTML('beforeend', html);
    variationCount++;
    attachStockListener();
});

// Update total stock dynamically
function updateProductStock() {
    let total = 0;
    document.querySelectorAll('.variation-stock').forEach(input => {
        total += parseInt(input.value || 0);
    });
    document.getElementById('productStock').value = total;
}

// Attach stock listeners
function attachStockListener() {
    document.querySelectorAll('.variation-stock').forEach(input => {
        input.removeEventListener('input', updateProductStock);
        input.addEventListener('input', updateProductStock);
    });
}

attachStockListener();
updateProductStock();

// Media preview
const mediaInput = document.getElementById('mediaInput');
const mediaPreview = document.getElementById('mediaPreview');
let filesArray = [];

mediaInput.addEventListener('change', (event) => {
    const newFiles = Array.from(event.target.files);
    filesArray = [...filesArray, ...newFiles];
    displayMedia();
});

function displayMedia() {
    mediaPreview.innerHTML = '';
    filesArray.forEach((file, index) => {
        const mediaElement = document.createElement(file.type.startsWith('video') ? 'video' : 'img');
        mediaElement.src = URL.createObjectURL(file);
        mediaElement.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg', 'shadow');
        const wrapper = document.createElement('div');
        wrapper.classList.add('relative', 'inline-block');
        wrapper.appendChild(mediaElement);

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '×';
        removeBtn.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'p-1', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center', 'text-sm');
        removeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            filesArray.splice(index, 1);
            displayMedia();
        });
        wrapper.appendChild(removeBtn);
        mediaPreview.appendChild(wrapper);
    });
}
</script>
@endsection
