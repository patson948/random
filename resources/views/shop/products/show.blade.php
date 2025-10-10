<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">
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
                <div class="flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <a href="/" class="text-2xl font-bold">ShopHub</a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/search-demo?category=men" class="text-sm font-medium hover:text-gray-600">Men</a>
                    <a href="/search-demo?category=women" class="text-sm font-medium hover:text-gray-600">Women</a>
                    <a href="/search-demo?category=kids" class="text-sm font-medium hover:text-gray-600">Kids</a>
                    <a href="/search-demo?category=sports" class="text-sm font-medium hover:text-gray-600">Sports</a>
                    <a href="/categories-demo" class="text-sm font-medium hover:text-gray-600">Categories</a>
                    <a href="/search-demo?sale=1" class="text-sm font-medium text-red-600 hover:text-red-700">Sale</a>
                </div>

                <div class="flex items-center space-x-6">
                    <form action="{{ route('search') }}" method="GET" class="hidden lg:block relative">
                        <input type="text" name="q" placeholder="Search products..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black">
                        <button type="submit" class="absolute left-3 top-2.5">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>

                    <a href="{{ route('cart.index') }}" class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                            <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </a>
                    @else
                        <button @click="$dispatch('open-login')" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                            <span class="text-sm font-medium">U</span>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between" x-data="{ show: true }" x-show="show">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between" x-data="{ show: true }" x-show="show">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-red-600 hover:text-red-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="/" class="hover:text-black">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="/search-demo" class="hover:text-black">Shop</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="/search-demo?category={{ $product->category->slug }}" class="hover:text-black">{{ $product->category->name }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-black font-medium">{{ Str::limit($product->name, 30) }}</span>
        </div>
    </div>

    <!-- Product Details -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ 
        selectedImage: 0,
        quantity: 1,
        selectedSize: '',
        selectedColor: ''
    }">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div>
                <!-- Main Image -->
                <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-4">
                    @if($product->images && count($product->images) > 0)
                        <template x-for="(image, index) in {{ json_encode($product->images) }}" :key="index">
                            <img :src="image" 
                                 x-show="selectedImage === index"
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        </template>
                    @else
                        <img src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=800&q=80" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    @endif
                </div>

                <!-- Thumbnail Images -->
                @if($product->images && count($product->images) > 1)
                <div class="grid grid-cols-3 gap-4">
                    @foreach($product->images as $index => $image)
                    <button @click="selectedImage = {{ $index }}" 
                            :class="selectedImage === {{ $index }} ? 'ring-2 ring-black' : ''"
                            class="aspect-square bg-gray-100 rounded-lg overflow-hidden hover:ring-2 hover:ring-black transition">
                        <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl lg:text-4xl font-bold mb-4">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 fill-current {{ $i <= round($product->average_rating) ? '' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm font-medium">{{ number_format($product->average_rating, 1) }}/5</span>
                    </div>
                    <span class="text-sm text-gray-500">({{ $product->review_count }} reviews)</span>
                </div>

                <!-- Price -->
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-4xl font-bold">ZMW {{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price && $product->compare_price > $product->price)
                        <span class="text-2xl text-gray-400 line-through">ZMW {{ number_format($product->compare_price, 2) }}</span>
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                            -{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                        </span>
                    @endif
                </div>

                <!-- Description -->
                <p class="text-gray-600 mb-6 leading-relaxed">
                    {{ $product->short_description ?? $product->description }}
                </p>

                <!-- Stock Status -->
                <div class="mb-6">
                    @if($product->quantity > 0)
                        <span class="inline-flex items-center gap-2 text-green-600 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            In Stock ({{ $product->quantity }} available)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-red-600 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Out of Stock
                        </span>
                    @endif
                </div>

                <hr class="my-6">

                <!-- Quantity Selector -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-3">Quantity</label>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center border rounded-lg">
                            <button @click="quantity = Math.max(1, quantity - 1)" class="px-4 py-2 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <input type="number" x-model="quantity" min="1" max="{{ $product->quantity }}" class="w-16 text-center border-x py-2 focus:outline-none">
                            <button @click="quantity = Math.min({{ $product->quantity }}, quantity + 1)" class="px-4 py-2 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart -->
                <div class="flex gap-4 mb-8">
                    @if($product->quantity > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="quantity" x-model="quantity">
                            <button type="submit" class="w-full bg-black text-white py-4 rounded-full font-medium hover:bg-gray-800 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled class="flex-1 bg-gray-300 text-gray-500 py-4 rounded-full font-medium cursor-not-allowed flex items-center justify-center gap-2">
                            Out of Stock
                        </button>
                    @endif
                    <button class="w-14 h-14 border-2 border-black rounded-full flex items-center justify-center hover:bg-black hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>

                <!-- Product Details -->
                <div class="bg-gray-50 rounded-2xl p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Category</span>
                        <a href="/search-demo?category={{ $product->category->slug }}" class="font-medium hover:underline">{{ $product->category->name }}</a>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Vendor</span>
                        <span class="font-medium">{{ $product->vendor->store_name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">SKU</span>
                        <span class="font-medium">{{ $product->sku }}</span>
                    </div>
                    @if($product->is_featured)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status</span>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">Featured</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Description & Reviews -->
        <div class="mt-16" x-data="{ activeTab: 'description' }">
            <div class="border-b flex gap-8 mb-8">
                <button @click="activeTab = 'description'" 
                        :class="activeTab === 'description' ? 'border-b-2 border-black font-semibold' : 'text-gray-600'"
                        class="pb-4 px-2 transition">
                    Product Description
                </button>
                <button @click="activeTab = 'reviews'" 
                        :class="activeTab === 'reviews' ? 'border-b-2 border-black font-semibold' : 'text-gray-600'"
                        class="pb-4 px-2 transition">
                    Reviews ({{ $product->review_count }})
                </button>
            </div>

            <!-- Description Tab -->
            <div x-show="activeTab === 'description'" class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
            </div>

            <!-- Reviews Tab -->
            <div x-show="activeTab === 'reviews'" class="space-y-6">
                @forelse($product->reviews as $review)
                <div class="border-b pb-6">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold">{{ $review->user->name }}</span>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 fill-current {{ $i <= $review->rating ? '' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $review->comment }}</p>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-8">You Might Also Like</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related) }}" class="group">
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-4">
                        <img src="{{ $related->main_image ?? 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&q=80' }}" 
                             alt="{{ $related->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    <h3 class="font-semibold mb-2">{{ Str::limit($related->name, 40) }}</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold">ZMW {{ number_format($related->price, 0) }}</span>
                        @if($related->compare_price)
                            <span class="text-sm text-gray-400 line-through">ZMW {{ number_format($related->compare_price, 0) }}</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-16 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">ShopHub</h3>
                    <p class="text-sm text-gray-600">Your one-stop marketplace for quality products from trusted vendors.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="/search-demo?category=men" class="hover:text-black">Men</a></li>
                        <li><a href="/search-demo?category=women" class="hover:text-black">Women</a></li>
                        <li><a href="/search-demo?category=kids" class="hover:text-black">Kids</a></li>
                        <li><a href="/search-demo?sale=1" class="hover:text-black">Sale</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Customer Service</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-black">Contact Us</a></li>
                        <li><a href="#" class="hover:text-black">Track Order</a></li>
                        <li><a href="#" class="hover:text-black">Returns</a></li>
                        <li><a href="#" class="hover:text-black">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-black hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-black hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-black hover:text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t pt-8 text-center text-sm text-gray-600">
                <p>&copy; 2024 ShopHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>