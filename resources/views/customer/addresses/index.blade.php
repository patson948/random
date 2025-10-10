<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Addresses - ShopHub</title>
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
                            <a href="/addresses" class="block px-4 py-2 text-sm bg-gray-50 font-medium">Addresses</a>
                            <a href="/profile" class="block px-4 py-2 text-sm hover:bg-gray-50">Settings</a>
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="/dashboard" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">My Addresses</h1>
                    <p class="text-gray-600">Manage your saved shipping addresses</p>
                </div>
                <a href="{{ route('customer.addresses.create') }}" class="bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                    + Add New Address
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
        @endif

        <!-- Addresses Grid -->
        @if($addresses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($addresses as $address)
                <div class="bg-white rounded-2xl p-6 border {{ $address->is_default ? 'border-black' : 'border-gray-100' }} relative">
                    @if($address->is_default)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-black text-white text-xs font-medium rounded-full">Default</span>
                    </div>
                    @endif

                    <div class="mb-4">
                        @if($address->label)
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">{{ $address->label }}</span>
                        </div>
                        @endif
                        <p class="font-semibold text-lg">{{ $address->name }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $address->phone }}</p>
                    </div>

                    <div class="mb-4 text-sm text-gray-600">
                        <p>{{ $address->address }}</p>
                        <p>{{ $address->city }}, {{ $address->state }}</p>
                        <p>{{ $address->country }} @if($address->postal_code) - {{ $address->postal_code }} @endif</p>
                    </div>

                    <div class="flex gap-2 pt-4 border-t">
                        @if(!$address->is_default)
                        <form action="{{ route('customer.addresses.set-default', $address) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">
                                Set as Default
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('customer.addresses.edit', $address) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">
                            Edit
                        </a>
                        <form action="{{ route('customer.addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this address?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 border border-red-300 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl p-12 text-center">
                <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="text-xl font-bold mb-2">No addresses saved</h3>
                <p class="text-gray-600 mb-6">Add your first shipping address to make checkout faster</p>
                <a href="{{ route('customer.addresses.create') }}" class="inline-block bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                    Add Address
                </a>
            </div>
        @endif
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

