<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    @include('components.shop-navigation')

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="/" class="hover:text-black">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-black font-medium">Search Results</span>
        </div>
    </div>

    <!-- Search Results Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ 
        showFilters: false,
        priceRange: [{{ request('min_price', 0) }}, {{ request('max_price', 300000) }}],
        sortBy: '{{ request('sort', 'newest') }}'
    }">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-80 flex-shrink-0">
                <!-- Mobile Filter Toggle -->
                <button @click="showFilters = !showFilters" class="lg:hidden w-full mb-4 px-4 py-3 bg-black text-white rounded-full font-medium flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filters
                </button>

                <!-- Filters Panel -->
                <div :class="showFilters ? 'block' : 'hidden lg:block'" class="bg-white lg:bg-transparent rounded-2xl lg:rounded-none p-6 lg:p-0 border lg:border-0">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold">Filters</h3>
                            <a href="{{ route('search') }}" class="text-sm text-gray-600 hover:text-black">Clear All</a>
                        </div>

                        <div class="space-y-6">
                            <!-- Search Query -->
                            @if(request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            <!-- Categories -->
                            @if(isset($categories) && $categories->count() > 0)
                            <div class="border-b pb-6">
                                <h4 class="font-semibold mb-4">Categories</h4>
                                <div class="space-y-3">
                                    @foreach($categories as $category)
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="radio" 
                                               name="category" 
                                               value="{{ $category->id }}" 
                                               {{ request('category') == $category->id ? 'checked' : '' }}
                                               class="w-5 h-5 text-black">
                                        <span class="text-sm">{{ $category->name }}</span>
                                        <span class="ml-auto text-xs text-gray-500">({{ $category->products_count ?? 0 }})</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Price Range -->
                            <div class="border-b pb-6">
                                <h4 class="font-semibold mb-4">Price Range</h4>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-xs text-gray-600">Min Price</label>
                                            <input type="number" 
                                                   name="min_price" 
                                                   value="{{ request('min_price') }}" 
                                                   placeholder="0"
                                                   class="w-full px-3 py-2 border rounded-lg text-sm">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-600">Max Price</label>
                                            <input type="number" 
                                                   name="max_price" 
                                                   value="{{ request('max_price') }}" 
                                                   placeholder="300000"
                                                   class="w-full px-3 py-2 border rounded-lg text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Availability -->
                            <div class="border-b pb-6">
                                <h4 class="font-semibold mb-4">Availability</h4>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" 
                                           name="in_stock" 
                                           value="1" 
                                           {{ request('in_stock') ? 'checked' : '' }}
                                           class="w-5 h-5 rounded border-gray-300">
                                    <span class="text-sm">In Stock Only</span>
                                </label>
                            </div>

                            <!-- Vendors/Brands -->
                            @if(isset($vendors) && $vendors->count() > 0)
                            <div class="pb-6">
                                <h4 class="font-semibold mb-4">Brands/Vendors</h4>
                                <div class="space-y-3 max-h-64 overflow-y-auto">
                                    @foreach($vendors->take(10) as $vendor)
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="radio" 
                                               name="vendor" 
                                               value="{{ $vendor->id }}" 
                                               {{ request('vendor') == $vendor->id ? 'checked' : '' }}
                                               class="w-5 h-5 text-black">
                                        <span class="text-sm">{{ $vendor->shop_name ?? $vendor->store_name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Apply Filters Button -->
                            <button type="submit" class="w-full bg-black text-white py-3 rounded-full font-medium hover:bg-gray-800 transition">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Results Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold mb-1">
                            @if(request('q'))
                                Search Results for "{{ request('q') }}"
                            @else
                                All Products
                            @endif
                        </h1>
                        <p class="text-gray-600">Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} results</p>
                    </div>

                    <!-- Sort By -->
                    <form action="{{ route('search') }}" method="GET" class="flex items-center gap-2">
                        <!-- Preserve existing filters -->
                        @if(request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('vendor'))
                            <input type="hidden" name="vendor" value="{{ request('vendor') }}">
                        @endif
                        @if(request('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        @if(request('in_stock'))
                            <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                        @endif

                        <label class="text-sm text-gray-600">Sort by:</label>
                        <select name="sort" 
                                onchange="this.form.submit()"
                                class="px-4 py-2 border border-gray-300 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    @forelse($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="group cursor-pointer">
                        <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-4 relative">
                            <img src="{{ ($product->images && count($product->images) > 0) ? $product->images[0] : 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&q=80' }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            
                            @if($product->compare_price && $product->compare_price > $product->price)
                                <span class="absolute top-3 left-3 bg-red-100 text-red-600 text-xs font-semibold px-2 py-1 rounded-full">
                                    -{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                </span>
                            @endif

                            @if($product->quantity == 0)
                                <span class="absolute top-3 right-3 bg-gray-900 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                    Out of Stock
                                </span>
                            @endif

                            <button class="absolute bottom-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <h3 class="font-semibold mb-1">{{ Str::limit($product->name, 40) }}</h3>
                        
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 fill-current {{ $i <= round($product->average_rating) ? '' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm">{{ number_format($product->average_rating, 1) }}/5</span>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-bold">ZMW {{ number_format($product->price, 0) }}</span>
                            @if($product->compare_price && $product->compare_price > $product->price)
                                <span class="text-sm text-gray-400 line-through">ZMW {{ number_format($product->compare_price, 0) }}</span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">No products found</h3>
                        <p class="text-gray-600 mb-6">Try adjusting your filters or search query</p>
                        <a href="{{ route('search') }}" class="inline-flex items-center gap-2 bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                            Clear All Filters
                        </a>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if(isset($products) && $products->hasPages())
                <div class="flex justify-center items-center gap-2 mt-12">
                    {{-- Previous Button --}}
                    @if($products->onFirstPage())
                        <span class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full text-gray-400 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if($page == $products->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center bg-black text-white rounded-full font-medium">{{ $page }}</span>
                        @elseif($page == 1 || $page == $products->lastPage() || abs($page - $products->currentPage()) <= 2)
                            <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full hover:bg-gray-50 transition">{{ $page }}</a>
                        @elseif(abs($page - $products->currentPage()) == 3)
                            <span class="px-2">...</span>
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full hover:bg-gray-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <span class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-full text-gray-400 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    @endif
                </div>
                @endif
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

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>
