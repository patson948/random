<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <!-- Authentication Modals -->
    @include('components.auth-modals')
    
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <span>Free shipping on orders over ZMW 50,000</span>
            <div class="flex gap-4">
                <span>Help</span>
                <span>Track Order</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white border-b sticky top-0 z-50" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <a href="/" class="text-2xl font-bold">ShopHub</a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/search?category=men" class="text-sm font-medium hover:text-gray-600">Men</a>
                    <a href="/search?category=women" class="text-sm font-medium hover:text-gray-600">Women</a>
                    <a href="/search?category=kids" class="text-sm font-medium hover:text-gray-600">Kids</a>
                    <a href="/search?category=sports" class="text-sm font-medium hover:text-gray-600">Sports</a>
                    <a href="/categories-demo" class="text-sm font-medium hover:text-gray-600">Categories</a>
                    <a href="/search?sale=1" class="text-sm font-medium text-red-600 hover:text-red-700">Sale</a>
                </div>

                <!-- Right Menu -->
                <div class="flex items-center space-x-6">
                    <!-- Search -->
                    <form action="{{ route('search') }}" method="GET" class="hidden lg:block relative">
                        <input type="text" name="q" placeholder="Search products..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black">
                        <button type="submit" class="absolute left-3 top-2.5">
                            <svg class="w-5 h-5 text-gray-400 hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>

                    <!-- Icons -->
                    <a href="{{ route('cart.index') }}" class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @php
                            $cartCount = auth()->check() 
                                ? \App\Models\Cart::where('user_id', auth()->id())->sum('quantity')
                                : \App\Models\Cart::where('session_id', session()->getId())->sum('quantity');
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <a href="/favorites" class="hidden md:block">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </a>

                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 border">
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Admin Dashboard</a>
                            @elseif(auth()->user()->role === 'vendor')
                                <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Vendor Dashboard</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">My Dashboard</a>
                                <a href="{{ route('customer.orders.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">My Orders</a>
                                <a href="{{ route('customer.addresses.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">My Addresses</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="border-t mt-2 pt-2">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <button @click="$dispatch('open-login')" class="flex items-center space-x-2 hover:opacity-80 transition">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </button>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="/" class="hover:text-black">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-black font-medium">Categories</span>
        </div>
    </div>

    <!-- Page Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4">Browse by Category</h1>
            <p class="text-lg text-gray-600">Explore our wide range of products organized by category</p>
        </div>

        <!-- Main Categories -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Men's Fashion -->
            <a href="{{ route('search') }}?category=men" class="group relative overflow-hidden rounded-3xl aspect-[4/5] bg-gray-100">
                <img src="https://images.unsplash.com/photo-1516257984-b1b4d707412e?w=800&q=80" alt="Men's Fashion" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <h3 class="text-3xl font-bold mb-2">Men's Fashion</h3>
                    <p class="text-sm opacity-90 mb-4">Shirts, Pants, Shoes & More</p>
                    <div class="inline-flex items-center gap-2 text-sm font-medium">
                        <span>Shop Now</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Women's Fashion -->
            <a href="{{ route('search') }}?category=women" class="group relative overflow-hidden rounded-3xl aspect-[4/5] bg-gray-100">
                <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&q=80" alt="Women's Fashion" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <h3 class="text-3xl font-bold mb-2">Women's Fashion</h3>
                    <p class="text-sm opacity-90 mb-4">Dresses, Tops, Accessories</p>
                    <div class="inline-flex items-center gap-2 text-sm font-medium">
                        <span>Shop Now</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Kids -->
            <a href="{{ route('search') }}?category=kids" class="group relative overflow-hidden rounded-3xl aspect-[4/5] bg-gray-100">
                <img src="https://images.unsplash.com/photo-1503944583220-79d8926ad5e2?w=800&q=80" alt="Kids" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    <h3 class="text-3xl font-bold mb-2">Kids</h3>
                    <p class="text-sm opacity-90 mb-4">Clothes, Shoes, Toys</p>
                    <div class="inline-flex items-center gap-2 text-sm font-medium">
                        <span>Shop Now</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Sub Categories Grid -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Popular Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <!-- T-Shirts -->
                <a href="{{ route('search') }}?q=t-shirts" class="group bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 text-center transition">
                    <div class="w-16 h-16 bg-white rounded-full mx-auto mb-3 flex items-center justify-center shadow-sm group-hover:shadow-md transition">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-sm">T-Shirts</h3>
                </a>

                <!-- Jeans -->
                <a href="{{ route('search') }}?q=jeans" class="group bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 text-center transition">
                    <div class="w-16 h-16 bg-white rounded-full mx-auto mb-3 flex items-center justify-center shadow-sm group-hover:shadow-md transition">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-sm">Jeans</h3>
                </a>

                <!-- Shoes -->
                <a href="{{ route('search') }}?q=shoes" class="group bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 text-center transition">
                    <div class="w-16 h-16 bg-white rounded-full mx-auto mb-3 flex items-center justify-center shadow-sm group-hover:shadow-md transition">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-sm">Shoes</h3>
                </a>

                <!-- Dresses -->
                <a href="{{ route('search') }}?q=dresses" class="group bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 text-center transition">
                    <div class="w-16 h-16 bg-white rounded-full mx-auto mb-3 flex items-center justify-center shadow-sm group-hover:shadow-md transition">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-sm">Dresses</h3>
                </a>

                <!-- Accessories -->
                <a href="{{ route('search') }}?q=accessories" class="group bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 text-center transition">
                    <div class="w-16 h-16 bg-white rounded-full mx-auto mb-3 flex items-center justify-center shadow-sm group-hover:shadow-md transition">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-sm">Accessories</h3>
                </a>

                <!-- Sports -->
                <a href="{{ route('search') }}?category=sports" class="group bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 text-center transition">
                    <div class="w-16 h-16 bg-white rounded-full mx-auto mb-3 flex items-center justify-center shadow-sm group-hover:shadow-md transition">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-sm">Sports</h3>
                </a>
            </div>
        </div>

        <!-- Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Can't Find What You're Looking For?</h2>
            <p class="text-lg mb-6 opacity-90">Use our search feature to find exactly what you need</p>
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Search for products, brands, and more..." class="w-full px-6 py-4 rounded-full text-gray-900 focus:outline-none focus:ring-4 focus:ring-white/30">
                    <button type="submit" class="absolute right-2 top-2 bg-black text-white px-6 py-2 rounded-full font-medium hover:bg-gray-800 transition">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 pt-16 pb-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-12">
                <div class="col-span-2">
                    <h3 class="text-2xl font-bold mb-4">ShopHub</h3>
                    <p class="text-gray-600 mb-6">We have clothes that suits your style.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">COMPANY</h4>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="{{ route('about') }}" class="hover:text-black">About</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-black">Contact</a></li>
                        <li><a href="/search" class="hover:text-black">Shop</a></li>
                        <li><a href="/categories-demo" class="hover:text-black">Categories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">HELP</h4>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="{{ route('faq') }}" class="hover:text-black">FAQ</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-black">Customer Support</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-black">Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-black">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">SHOP</h4>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="/search?category=men" class="hover:text-black">Men's Fashion</a></li>
                        <li><a href="/search?category=women" class="hover:text-black">Women's Fashion</a></li>
                        <li><a href="/search?category=kids" class="hover:text-black">Kids</a></li>
                        <li><a href="/search?sale=1" class="hover:text-black">Sale Items</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t pt-8 text-center text-sm text-gray-600">
                <p>ShopHub © 2000-{{ date('Y') }}, All Rights Reserved</p>
            </div>
        </div>
    </footer>
</body>
</html>
