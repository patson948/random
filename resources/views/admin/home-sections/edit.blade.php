@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('admin.home-sections.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Home Sections
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">Edit Home Section</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Type -->
                <div class="mb-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Section Type *</label>
                    <select name="type" id="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent" onchange="updateFieldVisibility()">
                        <option value="">Select Type</option>
                        <option value="hero_slide" {{ old('type', $homeSection->type) === 'hero_slide' ? 'selected' : '' }}>Hero Slide</option>
                        <option value="cta_banner" {{ old('type', $homeSection->type) === 'cta_banner' ? 'selected' : '' }}>CTA Banner</option>
                        <option value="top_bar" {{ old('type', $homeSection->type) === 'top_bar' ? 'selected' : '' }}>Top Bar Message</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $homeSection->title) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subtitle -->
                <div class="mb-6 field-hero field-cta">
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $homeSection->subtitle) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    @error('subtitle')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6 field-hero field-cta">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">{{ old('description', $homeSection->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Badge -->
                <div class="mb-6 field-hero field-cta">
                    <label for="badge" class="block text-sm font-medium text-gray-700 mb-2">Badge Text</label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge', $homeSection->badge) }}" placeholder="e.g., NEW COLLECTION" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    @error('badge')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Text -->
                <div class="mb-6 field-hero field-cta">
                    <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                    <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $homeSection->button_text) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    @error('button_text')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Link -->
                <div class="mb-6 field-hero field-cta">
                    <label for="button_link" class="block text-sm font-medium text-gray-700 mb-2">Button Link</label>
                    <input type="text" name="button_link" id="button_link" value="{{ old('button_link', $homeSection->button_link) }}" placeholder="/search" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    @error('button_link')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image -->
                @if($homeSection->image)
                <div class="mb-6 field-hero field-cta">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <img src="{{ $homeSection->image }}" alt="{{ $homeSection->title }}" class="w-64 h-40 object-cover rounded-lg border border-gray-300">
                </div>
                @endif

                <!-- Image -->
                <div class="mb-6 field-hero field-cta">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">{{ $homeSection->image ? 'Replace Image' : 'Image' }}</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Max size: 2MB. Formats: JPG, PNG, GIF, WEBP</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gradient -->
                <div class="mb-6 field-hero field-cta">
                    <label for="gradient" class="block text-sm font-medium text-gray-700 mb-2">Gradient Classes</label>
                    <input type="text" name="gradient" id="gradient" value="{{ old('gradient', $homeSection->gradient) }}" placeholder="from-gray-50 to-gray-100" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Tailwind CSS gradient classes (e.g., from-blue-500 to-purple-600)</p>
                    @error('gradient')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div class="mb-6">
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Order *</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $homeSection->order) }}" min="0" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Lower numbers appear first</p>
                    @error('order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }} class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.home-sections.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">Update Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateFieldVisibility() {
    const type = document.getElementById('type').value;
    const heroFields = document.querySelectorAll('.field-hero');
    const ctaFields = document.querySelectorAll('.field-cta');
    
    heroFields.forEach(field => field.style.display = 'none');
    ctaFields.forEach(field => field.style.display = 'none');
    
    if (type === 'hero_slide') {
        heroFields.forEach(field => field.style.display = 'block');
    } else if (type === 'cta_banner') {
        ctaFields.forEach(field => field.style.display = 'block');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', updateFieldVisibility);
</script>
@endsection

