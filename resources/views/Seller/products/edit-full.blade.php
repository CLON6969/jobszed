@extends('layouts.seller')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Edit Product</h1>

    <form id="productForm" action="{{ route('Seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- PRODUCT INFORMATION --}}
        <h2 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-700">Product Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring focus:ring-blue-300 @error('name') border-red-500 @enderror" required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Category</label>
                <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring focus:ring-blue-300 @error('category_id') border-red-500 @enderror" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border-gray-300 rounded-lg shadow-sm p-3 @error('price') border-red-500 @enderror" required>
                @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Stock Quantity (Calculated)</label>
                <input type="number" id="productStock" value="{{ old('stock_quantity', $product->variations->sum('stock')) }}" readonly class="w-full border-gray-300 rounded-lg shadow-sm p-3 bg-gray-100 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Condition</label>
                <select name="condition" class="w-full border-gray-300 rounded-lg shadow-sm p-3 @error('condition') border-red-500 @enderror">
                    <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                    <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                </select>
                @error('condition') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-600 mb-1 font-medium">Delivery Available</label>
                <select name="delivery_available" class="w-full border-gray-300 rounded-lg shadow-sm p-3 @error('delivery_available') border-red-500 @enderror">
                    <option value="1" {{ old('delivery_available', $product->delivery_available) == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('delivery_available', $product->delivery_available) == 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('delivery_available') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-600 mb-1 font-medium">Location</label>
                <input type="text" name="location" value="{{ old('location', $product->location) }}" class="w-full border-gray-300 rounded-lg shadow-sm p-3 @error('location') border-red-500 @enderror">
                @error('location') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-600 mb-1 font-medium">Description</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm p-3 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        {{-- MEDIA --}}
        <h2 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-700">Product Media</h2>
        <div class="mb-6">
            <label class="block text-gray-600 mb-2 font-medium">Upload Images/Videos</label>
            <input id="mediaInput" type="file" name="media[]" multiple accept="image/*,video/*" class="hidden">
            <div id="mediaPreview" class="flex flex-wrap gap-4 border-2 border-dashed border-gray-300 p-4 rounded-lg justify-center cursor-pointer" onclick="document.getElementById('mediaInput').click()">
                @forelse($product->media as $media)
                    <div class="relative inline-block">
                        @if($media->media_type === 'image')
                            <img src="{{ asset('public/storage/'.$media->file_path) }}" class="w-32 h-32 object-cover rounded-lg shadow">
                        @else
                            <video class="w-32 h-32 object-cover rounded-lg shadow" controls>
                                <source src="{{ asset('public/storage/'.$media->file_path) }}" type="video/mp4">
                            </video>
                        @endif
                        <button type="button" onclick="removeExistingMedia({{ $media->id }}, this)" class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm">×</button>
                        @if($media->is_primary)
                            <span class="absolute top-1 left-1 bg-blue-600 text-white text-xs px-1 rounded">Primary</span>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-center w-full">Click or Drop Files to Upload</p>
                @endforelse
            </div>
            @error('media.*') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- VARIATIONS --}}
        <h2 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-700">Product Variations</h2>
        <div id="variation-section">
            @foreach(old('variations', $product->variations->toArray()) as $i => $var)
                <div class="variation-group mb-4 border rounded p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" name="variations[{{ $i }}][name]" placeholder="Variation Name" value="{{ $var['name'] }}" class="border rounded p-2">
                        <input type="text" name="variations[{{ $i }}][option]" placeholder="Option" value="{{ $var['option'] }}" class="border rounded p-2">
                        <input type="number" step="0.01" name="variations[{{ $i }}][price_adjustment]" placeholder="Price Adjustment" value="{{ $var['price_adjustment'] }}" class="border rounded p-2">
                        <input type="number" name="variations[{{ $i }}][stock]" placeholder="Stock" value="{{ $var['stock'] }}" class="border rounded p-2 variation-stock">
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
let variationCount = {{ count(old('variations', $product->variations)) }};

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

function updateProductStock() {
    let total = 0;
    document.querySelectorAll('.variation-stock').forEach(input => {
        total += parseInt(input.value || 0);
    });
    document.getElementById('productStock').value = total;
}

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
    filesArray.forEach((file,index)=>{
        const mediaElement = document.createElement(file.type.startsWith('video')?'video':'img');
        mediaElement.src = URL.createObjectURL(file);
        mediaElement.classList.add('w-32','h-32','object-cover','rounded-lg','shadow');
        mediaElement.setAttribute('draggable',true);

        const wrapper = document.createElement('div');
        wrapper.classList.add('relative','inline-block');
        wrapper.appendChild(mediaElement);

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML='×';
        removeBtn.classList.add('absolute','top-0','right-0','bg-red-500','text-white','rounded-full','p-1','w-6','h-6','flex','items-center','justify-center','text-sm');
        removeBtn.addEventListener('click',(e)=>{
            e.stopPropagation();
            filesArray.splice(index,1);
            displayMedia();
        });
        wrapper.appendChild(removeBtn);
        mediaPreview.appendChild(wrapper);
    });
}

// Remove existing media
function removeExistingMedia(id, btn){
    if(confirm('Delete this media?')){
        const input = document.createElement('input');
        input.type='hidden';
        input.name='delete_media[]';
        input.value=id;
        document.getElementById('productForm').appendChild(input);
        btn.parentElement.remove();
    }
}
</script>
@endsection
