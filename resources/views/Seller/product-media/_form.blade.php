<div x-data="mediaForm({{ isset($product) ? $product->media->toJson() : '[]' }})" class="space-y-6">

    <!-- Existing Media (Edit Only) -->
   <!-- Existing Media (Edit Only) -->
<template x-if="existingMedia.length">
    <div>
        <h3 class="font-semibold mb-2">Current Media</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <template x-for="(media, index) in existingMedia" :key="media.id">
                <div class="relative border rounded overflow-hidden">
                    <!-- IMAGE PREVIEW -->
                    <template x-if="media.media_type === 'image'">
                        <img :src="`{{ asset('public/storage') }}/${media.file_path}`"
                             class="w-full h-32 object-cover rounded"
                             alt="Product Image">
                    </template>

                    <!-- VIDEO PREVIEW -->
                    <template x-if="media.media_type === 'video'">
                        <video class="w-full h-32" controls>
                            <source :src="`{{ asset('public/storage') }}/${media.file_path}`" type="video/mp4">
                        </video>
                    </template>

                    <!-- Remove checkbox -->
                    <label class="absolute top-1 left-1 bg-white rounded-full p-1 cursor-pointer text-xs">
                        <input type="checkbox" :value="media.id" x-model="removeExisting"> Remove
                    </label>

                    <!-- Primary radio -->
                    <label class="absolute bottom-1 left-1 bg-white rounded-full p-1 cursor-pointer text-xs">
                        <input type="radio" name="primary_existing" :value="media.id" x-model="primaryExisting"> Primary
                    </label>
                </div>
            </template>
        </div>
    </div>
</template>


    <!-- Upload New Media -->
    <div>
        <label class="block text-gray-700 mb-2">Upload New Media (Images/Videos)</label>
        <input type="file" name="media[]" multiple accept="image/*,video/*" @change="previewFiles($event)" class="w-full border-gray-300 rounded-lg p-2">

    </div>

    <!-- Preview New Media -->
    <template x-if="newFiles.length">
        <div>
            <h3 class="font-semibold mb-2">Preview New Media</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <template x-for="(file, index) in newFiles" :key="index">
                    <div class="relative border rounded overflow-hidden">
                        <template x-if="file.type.startsWith('image/')">
                            <img :src="file.url" class="w-full h-32 object-cover">
                        </template>
                        <template x-if="file.type.startsWith('video/')">
                            <video class="w-full h-32" controls>
                                <source :src="file.url" :type="file.type">
                            </video>
                        </template>

                        <!-- Remove button -->
                        <button type="button" @click="removeFile(index)" class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700">×</button>

                        <!-- Primary radio -->
                        <label class="absolute bottom-1 left-1 bg-white rounded-full p-1 cursor-pointer">
                            <input type="radio" name="primary_new" :value="index" x-model="primaryNew"> Primary
                        </label>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- Hidden fields for removed existing media -->
    <template x-for="id in removeExisting">
        <input type="hidden" name="remove_media[]" :value="id">
    </template>

    <input type="hidden" name="primary_existing" :value="primaryExisting">
    <input type="hidden" name="primary_new" :value="primaryNew">

    <div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ $buttonText }}</button>
    </div>
</div>

<script>
function mediaForm(existing = []) {
    return {
        existingMedia: existing,
        newFiles: [],
        removeExisting: [],
        primaryExisting: existing.find(m => m.is_primary)?.id || null,
        primaryNew: null,
        previewFiles(event) {
            for (let i = 0; i < event.target.files.length; i++) {
                let file = event.target.files[i];
                file.url = URL.createObjectURL(file);
                this.newFiles.push(file);
            }
        },
        removeFile(index) {
            if (this.primaryNew === index) this.primaryNew = null;
            this.newFiles.splice(index, 1);
        }
    }
}
</script>
