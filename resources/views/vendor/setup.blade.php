<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Vendor - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block mb-6">
                    <h2 class="text-3xl font-bold text-black">ShopHub</h2>
                </a>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Become a Vendor</h1>
                <p class="text-lg text-gray-600">Fill out the form below to start selling on ShopHub</p>
            </div>
            
            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                <form action="{{ route('vendor.setup.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Shop Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Shop Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="shop_name" 
                            value="{{ old('shop_name') }}" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="Enter your shop name"
                        >
                        @error('shop_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Shop Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Shop Description
                        </label>
                        <textarea 
                            name="description" 
                            rows="4" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="Tell customers about your shop and products"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="+260..."
                        >
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Business Address -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Business Address <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="address" 
                            rows="3" 
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                            placeholder="Enter your complete business address"
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Info Box -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 rounded-xl p-5">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-blue-800 mb-1">Review Process</h3>
                                <p class="text-sm text-blue-700">Your vendor account will be reviewed by our admin team. You'll be notified once approved, typically within 1-2 business days.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button 
                            type="submit" 
                            class="flex-1 bg-black text-white px-8 py-4 rounded-full hover:bg-gray-800 transition font-semibold text-lg"
                        >
                            Submit Application
                        </button>
                        <a 
                            href="{{ route('home') }}" 
                            class="flex-1 bg-gray-100 text-gray-900 px-8 py-4 rounded-full hover:bg-gray-200 transition font-semibold text-lg text-center"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Already have a vendor account? 
                    <a href="{{ route('login') }}" class="font-semibold text-black hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
