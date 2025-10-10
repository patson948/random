<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vendor - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true, showDeleteModal: false }">
    @include('admin.layouts.sidebar')

    <div class="lg:pl-64">
        @include('admin.layouts.header')

        <main class="p-6">
            <div class="max-w-4xl">
                <a href="{{ route('admin.vendors.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Vendors
                </a>

                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold">Edit Vendor</h1>
                    <button @click="showDeleteModal = true" class="px-4 py-2 border border-red-300 text-red-600 rounded-full font-medium hover:bg-red-50 transition">
                        Delete Vendor
                    </button>
                </div>

                <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl p-8 border border-gray-100">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <h2 class="text-lg font-bold">User Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $vendor->user->name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('name') border-red-500 @enderror" required>
                                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $vendor->user->email) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('email') border-red-500 @enderror" required>
                                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <hr class="my-8">
                        
                        <h2 class="text-lg font-bold">Store Information</h2>

                        <div>
                            <label class="block text-sm font-medium mb-2">Shop Name <span class="text-red-500">*</span></label>
                            <input type="text" name="shop_name" value="{{ old('shop_name', $vendor->shop_name) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('shop_name') border-red-500 @enderror" required>
                            @error('shop_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('description') border-red-500 @enderror">{{ old('description', $vendor->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Shop Logo</label>
                                @if($vendor->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $vendor->logo) }}" alt="Current Logo" class="w-24 h-24 rounded-xl object-cover">
                                    </div>
                                @endif
                                <input type="file" name="logo" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('logo') border-red-500 @enderror">
                                @error('logo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Shop Banner</label>
                                @if($vendor->banner)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $vendor->banner) }}" alt="Current Banner" class="w-full h-24 rounded-xl object-cover">
                                    </div>
                                @endif
                                <input type="file" name="banner" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('banner') border-red-500 @enderror">
                                @error('banner')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Phone</label>
                                <input type="tel" name="phone" value="{{ old('phone', $vendor->phone) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('phone') border-red-500 @enderror">
                                @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Commission Rate (%)</label>
                                <input type="number" step="0.01" name="commission_rate" value="{{ old('commission_rate', $vendor->commission_rate) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('commission_rate') border-red-500 @enderror">
                                @error('commission_rate')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Address</label>
                            <textarea name="address" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black @error('address') border-red-500 @enderror">{{ old('address', $vendor->address) }}</textarea>
                            @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_approved" value="1" {{ old('is_approved', $vendor->is_approved) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
                                <span class="text-sm font-medium">Approved</span>
                            </label>
                        </div>

                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit" class="flex-1 bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                                Update Vendor
                            </button>
                            <a href="{{ route('admin.vendors.index') }}" class="flex-1 text-center border border-gray-300 px-6 py-3 rounded-full font-medium hover:bg-gray-50 transition">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="showDeleteModal = false">
        <div class="bg-white rounded-3xl max-w-md w-full p-8">
            <h2 class="text-2xl font-bold mb-4">Delete Vendor?</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this vendor? This action cannot be undone and will also delete the user account.</p>
            <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" @click="showDeleteModal = false" class="flex-1 px-6 py-3 border border-gray-300 rounded-full font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-600 text-white rounded-full font-medium hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>

