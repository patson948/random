@extends('layouts.vendor')

@section('page-title', 'Add New Product')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Add New Product</h1>
        <p class="text-gray-600">Create a new product listing for your store</p>
    </div>
    <a href="{{ route('vendor.products.index') }}" class="inline-flex items-center gap-2 bg-gray-100 text-gray-900 px-6 py-3 rounded-full hover:bg-gray-200 transition font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Products
    </a>
</div>

<form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="imageUpload()">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Images -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Product Images</h2>
                
                <div class="space-y-4">
                    <!-- Upload Area -->
                    <div 
                        @dragover.prevent="dragOver = true"
                        @dragleave.prevent="dragOver = false"
                        @drop.prevent="handleDrop($event)"
                        :class="dragOver ? 'border-black bg-gray-50' : 'border-gray-300'"
                        class="border-2 border-dashed rounded-xl p-8 text-center transition cursor-pointer"
                        @click="$refs.fileInput.click()"
                    >
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm font-medium text-gray-900 mb-1">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF, WEBP up to 2MB each</p>
                        <input 
                            type="file" 
                            name="images[]" 
                            multiple 
                            accept="image/*"
                            class="hidden" 
                            x-ref="fileInput"
                            @change="handleFiles($event)"
                        >
                    </div>

                    <!-- Image Previews -->
                    <div x-show="previews.length > 0" class="grid grid-cols-3 gap-4">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="relative group">
                                <img :src="preview" class="w-full h-32 object-cover rounded-xl border border-gray-200">
                                <button 
                                    type="button"
                                    @click="removeImage(index)"
                                    class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition flex items-center justify-center"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                <span class="absolute bottom-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                    Image <span x-text="index + 1"></span>
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Basic Information</h2>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="Enter product name"
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="category_id" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                        >
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            Short Description
                        </label>
                        <textarea 
                            name="short_description" 
                            rows="3" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="Brief description for product cards"
                        >{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            Product Description <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="description" 
                            rows="6" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="Detailed description of the product"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Pricing & Inventory -->
        <div class="space-y-6">
            <!-- Pricing -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Pricing</h2>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            Price (ZMW) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="price" 
                            value="{{ old('price') }}" 
                            step="0.01" 
                            min="0" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="0.00"
                        >
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            Compare Price (ZMW)
                        </label>
                        <input 
                            type="number" 
                            name="compare_price" 
                            value="{{ old('compare_price') }}" 
                            step="0.01" 
                            min="0" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="0.00"
                        >
                        <p class="text-xs text-gray-500 mt-2">Original price to show discount</p>
                        @error('compare_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Inventory -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Inventory</h2>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            Stock Quantity <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="quantity" 
                            value="{{ old('quantity') }}" 
                            min="0" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="0"
                        >
                        @error('quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">
                            SKU
                        </label>
                        <input 
                            type="text" 
                            name="sku" 
                            value="{{ old('sku') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="PROD-001"
                        >
                        <p class="text-xs text-gray-500 mt-2">Leave empty to auto-generate</p>
                        @error('sku')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Visibility -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Visibility</h2>
                
                <div class="space-y-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="mt-1 w-5 h-5 text-black focus:ring-black border-gray-300 rounded"
                        >
                        <div>
                            <div class="text-sm font-medium text-gray-900">Active Product</div>
                            <p class="text-xs text-gray-500">Product is visible to customers</p>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_featured" 
                            value="1" 
                            {{ old('is_featured') ? 'checked' : '' }}
                            class="mt-1 w-5 h-5 text-black focus:ring-black border-gray-300 rounded"
                        >
                        <div>
                            <div class="text-sm font-medium text-gray-900">Featured Product</div>
                            <p class="text-xs text-gray-500">Show on homepage</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-4">
        <button 
            type="submit" 
            class="flex-1 bg-black text-white px-6 py-4 rounded-full hover:bg-gray-800 transition font-semibold text-lg"
        >
            Create Product
        </button>
        <a 
            href="{{ route('vendor.products.index') }}" 
            class="flex-1 bg-gray-100 text-gray-900 px-6 py-4 rounded-full hover:bg-gray-200 transition font-semibold text-lg text-center"
        >
            Cancel
        </a>
    </div>
</form>

<script>
function imageUpload() {
    return {
        dragOver: false,
        files: [],
        previews: [],
        
        handleFiles(event) {
            const files = Array.from(event.target.files);
            this.addFiles(files);
        },
        
        handleDrop(event) {
            this.dragOver = false;
            const files = Array.from(event.dataTransfer.files).filter(file => file.type.startsWith('image/'));
            this.addFiles(files);
        },
        
        addFiles(newFiles) {
            newFiles.forEach(file => {
                if (file.size <= 2 * 1024 * 1024) { // 2MB limit
                    this.files.push(file);
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previews.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            // Update file input
            this.updateFileInput();
        },
        
        removeImage(index) {
            this.files.splice(index, 1);
            this.previews.splice(index, 1);
            this.updateFileInput();
        },
        
        updateFileInput() {
            const dt = new DataTransfer();
            this.files.forEach(file => dt.items.add(file));
            this.$refs.fileInput.files = dt.files;
        }
    };
}
</script>
@endsection
