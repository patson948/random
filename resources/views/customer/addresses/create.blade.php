<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Address - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Authentication Modals -->
    @include('components.auth-modals')

    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <span>Free shipping on orders over ₦50,000</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white border-b sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-2xl font-bold">ShopHub</a>
                <div class="flex items-center gap-4">
                    <a href="/dashboard" class="text-sm font-medium hover:text-gray-600 transition">Dashboard</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('customer.addresses.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Addresses
            </a>
            <h1 class="text-3xl font-bold mb-2">Add New Address</h1>
            <p class="text-gray-600">Fill in the details below to add a new shipping address</p>
        </div>

        <div class="bg-white rounded-2xl p-8 border border-gray-100">
            <form action="{{ route('customer.addresses.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Street Address <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">{{ old('address') }}</textarea>
                    @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">City <span class="text-red-500">*</span></label>
                        <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('city')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">State <span class="text-red-500">*</span></label>
                        <input type="text" name="state" value="{{ old('state') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('state')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Country <span class="text-red-500">*</span></label>
                        <select name="country" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="Nigeria" {{ old('country') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                            <option value="Ghana" {{ old('country') == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                            <option value="Kenya" {{ old('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                            <option value="South Africa" {{ old('country') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                        </select>
                        @error('country')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('postal_code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Label (Optional)</label>
                    <select name="label" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        <option value="">No label</option>
                        <option value="Home" {{ old('label') == 'Home' ? 'selected' : '' }}>Home</option>
                        <option value="Office" {{ old('label') == 'Office' ? 'selected' : '' }}>Office</option>
                        <option value="Other" {{ old('label') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('label')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
                    <label for="is_default" class="ml-2 text-sm text-gray-700">Set as default address</label>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                        Save Address
                    </button>
                    <a href="{{ route('customer.addresses.index') }}" class="flex-1 text-center px-6 py-3 border border-gray-300 rounded-full font-medium hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

