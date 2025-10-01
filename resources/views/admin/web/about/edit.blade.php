@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Edit About Section</h2>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg shadow">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.web.about.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Section: Hero Titles -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-xl font-semibold text-gray-700">Hero Section</h3>

            <div class="space-y-2">
                <label class="block text-gray-600">Title 1</label>
                <input type="text" name="title1" value="{{ old('title1', $about->title1 ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400" required>
            </div>
            <div class="space-y-2">
                <label class="block text-gray-600">Title 1 Content</label>
                <textarea name="title1_content" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">{{ old('title1_content', $about->title1_content ?? '') }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-gray-600">Title 2</label>
                <input type="text" name="title2" value="{{ old('title2', $about->title2 ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400" required>
            </div>
            <div class="space-y-2">
                <label class="block text-gray-600">Title 2 Content</label>
                <textarea name="title2_content" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">{{ old('title2_content', $about->title2_content ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-gray-600">Button 1 Name</label>
                    <input type="text" name="button1_name" value="{{ old('button1_name', $about->button1_name ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">
                </div>
                <div class="space-y-2">
                    <label class="block text-gray-600">Button 1 URL</label>
                    <input type="url" name="button1_url" value="{{ old('button1_url', $about->button1_url ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">
                </div>
                <div class="space-y-2">
                    <label class="block text-gray-600">Button 2 Name</label>
                    <input type="text" name="button2_name" value="{{ old('button2_name', $about->button2_name ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">
                </div>
                <div class="space-y-2">
                    <label class="block text-gray-600">Button 2 URL</label>
                    <input type="url" name="button2_url" value="{{ old('button2_url', $about->button2_url ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">
                </div>
            </div>
        </div>

        <!-- Section: Additional Titles -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-xl font-semibold text-gray-700">Additional Titles</h3>

            <div class="space-y-2">
                <label class="block text-gray-600">Title 3</label>
                <input type="text" name="title3" value="{{ old('title3', $about->title3 ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">
            </div>
            <div class="space-y-2">
                <label class="block text-gray-600">Title 3 Content</label>
                <textarea name="title3_content" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">{{ old('title3_content', $about->title3_content ?? '') }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-gray-600">Title 4</label>
                <input type="text" name="title4" value="{{ old('title4', $about->title4 ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">
            </div>
            <div class="space-y-2">
                <label class="block text-gray-600">Title 4 Content</label>
                <textarea name="title4_content" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">{{ old('title4_content', $about->title4_content ?? '') }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-gray-600">Title 5</label>
                <input type="text" name="title5" value="{{ old('title5', $about->title5 ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">
            </div>

            <div class="space-y-2">
                <label class="block text-gray-600">Title 6</label>
                <input type="text" name="title6" value="{{ old('title6', $about->title6 ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-cyan-400 focus:border-cyan-400">
            </div>
        </div>

        <!-- Section: Background Images -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <h3 class="text-xl font-semibold text-gray-700">Background Pictures</h3>

            <div class="space-y-2">
                <label class="block text-gray-600">Background Picture</label>
                @if(!empty($about->background_picture))
                    <img src="{{ asset('/public/storage/uploads/pics/' . $about->background_picture) }}" class="w-48 rounded-lg shadow mb-2">
                @endif
                <input type="file" name="background_picture" class="w-full text-gray-600">
            </div>

            <div class="space-y-2">
                <label class="block text-gray-600">Background Picture 2</label>
                @if(!empty($about->background_picture2))
                    <img src="{{ asset('/public/storage/uploads/pics/' . $about->background_picture2) }}" class="w-48 rounded-lg shadow mb-2">
                @endif
                <input type="file" name="background_picture2" class="w-full text-gray-600">
            </div>
        </div>

        <div>
            <button type="submit" class="px-6 py-3 bg-cyan-500 text-white font-semibold rounded-lg shadow hover:bg-cyan-600 transition">Update About Section</button>
        </div>
    </form>
</div>
@endsection
