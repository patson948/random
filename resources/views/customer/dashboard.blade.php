<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - ShopHub</title>
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
                    <a href="{{ route('search') }}" class="hidden md:block">
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
                            <a href="/orders" class="block px-4 py-2 text-sm hover:bg-gray-50">My Orders</a>
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
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
            <p class="text-gray-600">Here's what's happening with your account</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Total Orders</h3>
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ $stats['total_orders'] }}</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Pending</h3>
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ $stats['pending_orders'] }}</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Completed</h3>
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ $stats['completed_orders'] }}</p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-600">Total Spent</h3>
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">ZMW {{ number_format($stats['total_spent'], 0) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Recent Orders</h2>
                        <a href="/orders" class="text-sm text-black hover:underline">View All</a>
                    </div>

                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                            <a href="/orders/{{ $order->id }}" class="block p-4 border border-gray-200 rounded-xl hover:border-black transition">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <p class="font-semibold">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold">ZMW {{ number_format($order->total, 2) }}</p>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'processing' => 'bg-blue-100 text-blue-700',
                                                'shipped' => 'bg-purple-100 text-purple-700',
                                                'delivered' => 'bg-green-100 text-green-700',
                                                'cancelled' => 'bg-red-100 text-red-700',
                                            ];
                                        @endphp
                                        <span class="inline-block px-3 py-1 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }} text-xs font-medium rounded-full mt-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @foreach($order->items->take(3) as $item)
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex-shrink-0"></div>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                    <span class="text-sm text-gray-600">+{{ $order->items->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <p class="text-gray-500 mb-4">No orders yet</p>
                            <a href="/products" class="inline-block bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions & Info -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="/orders" class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:border-black transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-sm font-medium">Track Orders</span>
                        </a>
                        <a href="/wishlist" class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:border-black transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="text-sm font-medium">My Wishlist</span>
                        </a>
                        <a href="{{ route('customer.addresses.index') }}" class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:border-black transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm font-medium">Saved Addresses</span>
                        </a>
                        <a href="{{ route('customer.profile.edit') }}" class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:border-black transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm font-medium">Account Settings</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Reviews -->
                @if($recentReviews->count() > 0)
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-4">Recent Reviews</h2>
                    <div class="space-y-4">
                        @foreach($recentReviews as $review)
                        <div class="pb-4 border-b last:border-0">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex text-yellow-400 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm font-medium">{{ $review->product->name }}</p>
                            @if($review->comment)
                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($review->comment, 80) }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Help & Support -->
                <div class="bg-gradient-to-br from-black to-gray-800 text-white rounded-2xl p-6">
                    <h3 class="text-lg font-bold mb-2">Need Help?</h3>
                    <p class="text-sm text-gray-300 mb-4">Our customer support team is here to help you 24/7</p>
                    <a href="/support" class="inline-block bg-white text-black px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-100 transition">
                        Contact Support
                    </a>
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

