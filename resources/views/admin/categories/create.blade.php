<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Admin</title>
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
            <div class="max-w-2xl">
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Categories
                </a>

                <h1 class="text-3xl font-bold mb-8">Add New Category</h1>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white rounded-2xl p-8 border border-gray-100">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium mb-2">Category Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('name') border-red-500 @enderror" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Icon/Emoji</label>
                            <input type="text" name="icon" value="{{ old('icon') }}" placeholder="📱" maxlength="10" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('icon') border-red-500 @enderror">
                            @error('icon')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
                                <span class="text-sm font-medium">Active</span>
                            </label>
                        </div>

                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit" class="flex-1 bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                                Create Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="flex-1 text-center border border-gray-300 px-6 py-3 rounded-full font-medium hover:bg-gray-50 transition">
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

