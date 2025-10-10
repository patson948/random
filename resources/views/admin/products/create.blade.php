<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }">
    @include('admin.layouts.sidebar')

    <div class="lg:pl-64">
        @include('admin.layouts.header')

        <main class="p-6">
            <div class="max-w-4xl">
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Products
                </a>

                <h1 class="text-3xl font-bold mb-8">Add New Product</h1>

                <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white rounded-2xl p-8 border border-gray-100">
                    @csrf

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Product Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('name') border-red-500 @enderror" required>
                                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">SKU</label>
                                <input type="text" name="sku" value="{{ old('sku') }}" placeholder="Auto-generated if empty" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('sku') border-red-500 @enderror">
                                @error('sku')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Description <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Category <span class="text-red-500">*</span></label>
                                <select name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('category_id') border-red-500 @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Vendor <span class="text-red-500">*</span></label>
                                <select name="vendor_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('vendor_id') border-red-500 @enderror" required>
                                    <option value="">Select Vendor</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->store_name }}</option>
                                    @endforeach
                                </select>
                                @error('vendor_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Price (ZMW) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('price') border-red-500 @enderror" required>
                                @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Compare Price (ZMW)</label>
                                <input type="number" step="0.01" name="compare_price" value="{{ old('compare_price') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('compare_price') border-red-500 @enderror">
                                @error('compare_price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Quantity <span class="text-red-500">*</span></label>
                                <input type="number" name="quantity" value="{{ old('quantity', 0) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('quantity') border-red-500 @enderror" required>
                                @error('quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
                                <span class="text-sm font-medium">Featured Product</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
                                <span class="text-sm font-medium">Active</span>
                            </label>
                        </div>

                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit" class="flex-1 bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                                Create Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="flex-1 text-center border border-gray-300 px-6 py-3 rounded-full font-medium hover:bg-gray-50 transition">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

