<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - ShopHub</title>
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
                    <a href="/search" class="hidden md:block">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </a>

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
                            <a href="/orders" class="block px-4 py-2 text-sm bg-gray-50 font-medium">My Orders</a>
                            <a href="/wishlist" class="block px-4 py-2 text-sm hover:bg-gray-50">Wishlist</a>
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
            <h1 class="text-3xl font-bold mb-2">My Orders</h1>
            <p class="text-gray-600">Track and manage your orders</p>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-4">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'processing' => 'bg-blue-100 text-blue-700',
                        'shipped' => 'bg-purple-100 text-purple-700',
                        'delivered' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                    ];
                @endphp

                @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="font-bold text-lg">{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-xl">₦{{ number_format($order->total, 2) }}</p>
                                <span class="inline-block px-3 py-1 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }} text-xs font-medium rounded-full mt-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="flex items-center gap-3 mb-4">
                            @foreach($order->items->take(4) as $item)
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0"></div>
                            @endforeach
                            @if($order->items->count() > 4)
                            <span class="text-sm text-gray-600">+{{ $order->items->count() - 4 }} more</span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 pt-4 border-t">
                            <a href="{{ route('customer.orders.show', $order) }}" class="flex-1 text-center px-4 py-2 bg-black text-white rounded-full text-sm font-medium hover:bg-gray-800 transition">
                                View Details
                            </a>
                            @if($order->status == 'delivered')
                            <button class="px-4 py-2 border border-gray-300 rounded-full text-sm font-medium hover:bg-gray-50 transition">
                                Review Items
                            </button>
                            @endif
                            @if(in_array($order->status, ['pending', 'processing']))
                            <button class="px-4 py-2 border border-red-300 text-red-600 rounded-full text-sm font-medium hover:bg-red-50 transition">
                                Cancel Order
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
            @endif
        @else
            <div class="bg-white rounded-2xl p-12 text-center">
                <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="text-xl font-bold mb-2">No orders yet</h3>
                <p class="text-gray-600 mb-6">Start shopping and your orders will appear here</p>
                <a href="/products" class="inline-block bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                    Start Shopping
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
                        <li><a href="/wishlist" class="hover:text-white">Wishlist</a></li>
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

