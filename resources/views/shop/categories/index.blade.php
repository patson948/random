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
<body class="bg-gray-50">
    @include('components.auth-modals')

    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <span>Free shipping on orders over ₦50,000</span>
            <div class="flex gap-4">
                <a href="/help" class="hover:underline">Help</a>
                <a href="/track-order-demo" class="hover:underline">Track Order</a>
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
                    <a href="{{ route('products.index', ['category' => 'men']) }}" class="text-sm font-medium hover:text-gray-600">Men</a>
                    <a href="{{ route('products.index', ['category' => 'women']) }}" class="text-sm font-medium hover:text-gray-600">Women</a>
                    <a href="{{ route('products.index', ['category' => 'kids']) }}" class="text-sm font-medium hover:text-gray-600">Kids</a>
                    <a href="{{ route('products.index', ['category' => 'sports']) }}" class="text-sm font-medium hover:text-gray-600">Sports</a>
                    <a href="{{ route('categories.index') }}" class="text-sm font-medium text-black border-b-2 border-black">Categories</a>
                    <a href="{{ route('deals') }}" class="text-sm font-medium text-red-600 hover:text-red-700">Sale</a>
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

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium hover:text-gray-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium hover:text-gray-600">Logout</button>
                        </form>
                    @else
                        <button @click="$dispatch('open-auth-modal', { mode: 'login' })" class="text-sm font-medium hover:text-gray-600">Sign In</button>
                    @endauth

                    <a href="/cart" class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu" class="md:hidden py-4 border-t" x-cloak>
                <a href="{{ route('products.index', ['category' => 'men']) }}" class="block py-2 text-sm font-medium">Men</a>
                <a href="{{ route('products.index', ['category' => 'women']) }}" class="block py-2 text-sm font-medium">Women</a>
                <a href="{{ route('products.index', ['category' => 'kids']) }}" class="block py-2 text-sm font-medium">Kids</a>
                <a href="{{ route('products.index', ['category' => 'sports']) }}" class="block py-2 text-sm font-medium">Sports</a>
                <a href="{{ route('categories.index') }}" class="block py-2 text-sm font-medium text-black">Categories</a>
                <a href="{{ route('deals') }}" class="block py-2 text-sm font-medium text-red-600">Sale</a>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center text-sm text-gray-600">
                <a href="/" class="hover:text-black">Home</a>
                <span class="mx-2">/</span>
                <span class="text-black font-medium">Categories</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4">Shop by Category</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Browse our wide selection of products organized by category</p>
        </div>

        <!-- Categories Grid -->
        @if($categories->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition">
                            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center group-hover:from-gray-200 group-hover:to-gray-300 transition">
                                <span class="text-6xl">{{ $category->icon ?? '📦' }}</span>
                            </div>
                            <div class="p-4 text-center">
                                <h3 class="font-semibold mb-1">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $category->products_count }} products</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-semibold mb-2">No categories yet</h3>
                <p class="text-gray-600">Categories will appear here once they are added</p>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">ShopHub</h3>
                    <p class="text-sm">Your one-stop marketplace for quality products from trusted vendors.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('products.index', ['category' => 'men']) }}" class="hover:text-white">Men</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'women']) }}" class="hover:text-white">Women</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'kids']) }}" class="hover:text-white">Kids</a></li>
                        <li><a href="{{ route('deals') }}" class="hover:text-white">Sale</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Customer Service</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">Track Order</a></li>
                        <li><a href="#" class="hover:text-white">Returns</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Newsletter</h4>
                    <p class="text-sm mb-4">Subscribe for exclusive offers</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Your email" class="flex-1 px-3 py-2 rounded bg-gray-800 border border-gray-700 text-sm">
                        <button class="bg-white text-black px-4 py-2 rounded font-medium text-sm hover:bg-gray-100">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>&copy; 2024 ShopHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>

