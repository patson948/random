<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(request('category')) {{ ucfirst(request('category')) }} - @endif
        @if(request('featured')) Featured Products - @endif
        @if(request('sale')) Sale - @endif
        Shop - ShopHub
    </title>
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
            <span>Free shipping on orders over ZMW 50,000</span>
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
                    <a href="{{ route('categories.index') }}" class="text-sm font-medium hover:text-gray-600">Categories</a>
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
                <a href="{{ route('categories.index') }}" class="block py-2 text-sm font-medium">Categories</a>
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
                @if(request('category'))
                    <span class="text-black font-medium">{{ ucfirst(request('category')) }}</span>
                @elseif(request('featured'))
                    <span class="text-black font-medium">Featured Products</span>
                @elseif(request('sale'))
                    <span class="text-black font-medium">Sale</span>
                @else
                    <span class="text-black font-medium">All Products</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
                    <!-- Categories -->
                    <div>
                        <h3 class="font-semibold mb-4">Categories</h3>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                   class="block text-sm py-1 hover:text-black {{ request('category') == $category->slug ? 'text-black font-medium' : 'text-gray-600' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <h3 class="font-semibold mb-4">Price Range</h3>
                        <form action="{{ route('products.index') }}" method="GET" class="space-y-3">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <div>
                                <label class="text-xs text-gray-600">Min Price</label>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="ZMW 0" class="w-full border rounded px-3 py-1.5 text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Max Price</label>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="ZMW 1,000,000" class="w-full border rounded px-3 py-1.5 text-sm">
                            </div>
                            <button type="submit" class="w-full bg-black text-white py-2 rounded text-sm font-medium hover:bg-gray-800">
                                Apply
                            </button>
                        </form>
                    </div>

                    <!-- Filters -->
                    <div>
                        <h3 class="font-semibold mb-4">Filters</h3>
                        <div class="space-y-2">
                            <a href="{{ route('products.index', array_merge(request()->except('sale', 'featured'), ['sale' => 1])) }}" 
                               class="flex items-center text-sm py-1 {{ request('sale') ? 'text-black font-medium' : 'text-gray-600' }}">
                                <span class="mr-2">🏷️</span> On Sale
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except('sale', 'featured'), ['featured' => 1])) }}" 
                               class="flex items-center text-sm py-1 {{ request('featured') ? 'text-black font-medium' : 'text-gray-600' }}">
                                <span class="mr-2">⭐</span> Featured
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">
                        @if(request('category'))
                            {{ ucfirst(request('category')) }}
                        @elseif(request('featured'))
                            Featured Products
                        @elseif(request('sale'))
                            Sale Items
                        @else
                            All Products
                        @endif
                        <span class="text-gray-500 text-base font-normal">({{ $products->total() }} items)</span>
                    </h1>

                    <div>
                        <form action="{{ route('products.index') }}" method="GET" class="inline">
                            @foreach(request()->except('sort') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="sort" onchange="this.form.submit()" class="border rounded px-3 py-2 text-sm">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product) }}" class="group">
                                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition">
                                    <div class="relative pb-[100%]">
                                        <img src="{{ $product->main_image ?? 'https://via.placeholder.com/400' }}" 
                                             alt="{{ $product->name }}" 
                                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition">
                                        @if($product->compare_price && $product->compare_price > $product->price)
                                            <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                                -{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                            </span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="absolute top-2 right-2 bg-yellow-400 text-black text-xs font-semibold px-2 py-1 rounded">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>
                                        <h3 class="font-medium mb-2 line-clamp-2">{{ $product->name }}</h3>
                                        <div class="flex items-center gap-2 mb-2">
                                            @if($product->compare_price)
                                                <span class="text-lg font-bold">ZMW {{ number_format($product->price, 2) }}</span>
                                                <span class="text-sm text-gray-400 line-through">ZMW {{ number_format($product->compare_price, 2) }}</span>
                                            @else
                                                <span class="text-lg font-bold">ZMW {{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1">
                                                <span class="text-yellow-400">⭐</span>
                                                <span class="text-sm">{{ number_format($product->average_rating, 1) }}</span>
                                                <span class="text-xs text-gray-500">({{ $product->review_count }})</span>
                                            </div>
                                            @if($product->quantity > 0)
                                                <span class="text-xs text-green-600 font-medium">In Stock</span>
                                            @else
                                                <span class="text-xs text-red-600 font-medium">Out of Stock</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">🔍</div>
                        <h3 class="text-xl font-semibold mb-2">No products found</h3>
                        <p class="text-gray-600">Try adjusting your filters or search terms</p>
                    </div>
                @endif
            </div>
        </div>
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

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>
