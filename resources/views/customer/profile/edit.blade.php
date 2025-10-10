<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - ShopHub</title>
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
            <div class="flex gap-4">
                <span>24/7 Customer Support</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white border-b sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-8">
                    <a href="/" class="text-2xl font-bold">ShopHub</a>
                    <div class="hidden md:flex gap-6">
                        <a href="/products" class="text-sm font-medium hover:text-gray-600 transition">Shop</a>
                        <a href="/categories" class="text-sm font-medium hover:text-gray-600 transition">Categories</a>
                        <a href="/deals" class="text-sm font-medium hover:text-gray-600 transition">Deals</a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="/cart" class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-black text-white text-xs rounded-full flex items-center justify-center">0</span>
                    </a>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gray-900 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 border">
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="/dashboard" class="block px-4 py-2 text-sm hover:bg-gray-50">Dashboard</a>
                            <a href="/orders" class="block px-4 py-2 text-sm hover:bg-gray-50">My Orders</a>
                            <a href="/addresses" class="block px-4 py-2 text-sm hover:bg-gray-50">Addresses</a>
                            <a href="/profile" class="block px-4 py-2 text-sm bg-gray-50 font-medium">Settings</a>
                            <form method="POST" action="/logout" class="border-t mt-2 pt-2">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-50">Sign Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="/dashboard" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold mb-2">Profile Settings</h1>
            <p class="text-gray-600">Manage your account information and security</p>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
        @endif

        <div class="space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-2xl p-8 border border-gray-100">
                <h2 class="text-xl font-bold mb-6">Profile Information</h2>
                <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @if($user->isDirty('email'))
                        <p class="text-sm text-gray-600 mt-2">Your email address is unverified. We'll send you a verification email.</p>
                        @endif
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-2xl p-8 border border-gray-100">
                <h2 class="text-xl font-bold mb-6">Change Password</h2>
                <form action="{{ route('customer.profile.updatePassword') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium mb-2">Current Password <span class="text-red-500">*</span></label>
                        <input type="password" name="current_password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">New Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Confirm New Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="bg-red-50 border border-red-200 rounded-2xl p-8">
                <h2 class="text-xl font-bold text-red-900 mb-4">Delete Account</h2>
                <p class="text-sm text-red-700 mb-6">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
                
                <div x-data="{ showDeleteModal: false }">
                    <button @click="showDeleteModal = true" class="bg-red-600 text-white px-8 py-3 rounded-full font-medium hover:bg-red-700 transition">
                        Delete Account
                    </button>

                    <!-- Delete Confirmation Modal -->
                    <div x-show="showDeleteModal" 
                         x-cloak
                         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
                         @click.self="showDeleteModal = false">
                        <div class="bg-white rounded-2xl p-8 max-w-md w-full">
                            <h3 class="text-xl font-bold mb-4">Are you sure?</h3>
                            <p class="text-gray-600 mb-6">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                            
                            <form action="{{ route('customer.profile.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                
                                <div class="mb-6">
                                    <label class="block text-sm font-medium mb-2">Password</label>
                                    <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                                    @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex gap-4">
                                    <button type="submit" class="flex-1 bg-red-600 text-white px-6 py-3 rounded-full font-medium hover:bg-red-700 transition">
                                        Delete Account
                                    </button>
                                    <button type="button" @click="showDeleteModal = false" class="flex-1 px-6 py-3 border border-gray-300 rounded-full font-medium hover:bg-gray-50 transition">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">ShopHub</h3>
                    <p class="text-gray-400 text-sm">Your one-stop shop for everything you need.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/products" class="hover:text-white">All Products</a></li>
                        <li><a href="/categories" class="hover:text-white">Categories</a></li>
                        <li><a href="/deals" class="hover:text-white">Deals</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Account</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/dashboard" class="hover:text-white">Dashboard</a></li>
                        <li><a href="/orders" class="hover:text-white">Orders</a></li>
                        <li><a href="/addresses" class="hover:text-white">Addresses</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/contact" class="hover:text-white">Contact Us</a></li>
                        <li><a href="/faq" class="hover:text-white">FAQ</a></li>
                        <li><a href="/shipping" class="hover:text-white">Shipping Info</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; 2025 ShopHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>

