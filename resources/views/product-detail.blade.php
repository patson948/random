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
    <!-- Authentication Modals -->
    @include('components.auth-modals')
    
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
    @endif
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
            <a href="{{ route('products.index') }}" class="hover:text-black">Shop</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-black">{{ $product->category->name }}</a>
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
        activeTab: 'details'
    }">
        <div class="grid lg:grid-cols-2 gap-12 mb-16">
            <!-- Product Images -->
            <div>
                <div class="grid grid-cols-4 gap-4">
                    <!-- Thumbnail Images -->
                    <div class="space-y-4">
                        @if($product->images && count($product->images) > 0)
                            @foreach($product->images as $index => $image)
                            <button @click="selectedImage = {{ $index }}" :class="selectedImage === {{ $index }} ? 'ring-2 ring-black' : ''" class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </button>
                            @endforeach
                        @else
                            <button class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=400&q=80" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </button>
                        @endif
                    </div>

                    <!-- Main Image -->
                    <div class="col-span-3">
                        <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden">
                            @if($product->images && count($product->images) > 0)
                                @foreach($product->images as $index => $image)
                                <img x-show="selectedImage === {{ $index }}" src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @endforeach
                            @else
                                <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&q=80" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <div class="mb-2">
                    <span class="inline-block bg-black text-white text-xs font-semibold px-3 py-1 rounded-full">{{ $product->vendor->shop_name }}</span>
                    @if(!$product->in_stock)
                        <span class="inline-block bg-red-100 text-red-600 text-xs font-semibold px-3 py-1 rounded-full ml-2">Out of Stock</span>
                    @endif
                </div>
                <h1 class="text-4xl font-bold mb-3">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->average_rating))
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            @else
                                <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm font-medium">{{ number_format($product->average_rating, 1) }}/5</span>
                    <span class="text-sm text-gray-500">({{ $product->review_count }} {{ Str::plural('review', $product->review_count) }})</span>
                </div>

                <!-- Price -->
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-4xl font-bold">ZMW {{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price && $product->compare_price > $product->price)
                        <span class="text-2xl text-gray-400 line-through">ZMW {{ number_format($product->compare_price, 2) }}</span>
                        @php
                            $discount = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
                        @endphp
                        <span class="bg-red-100 text-red-600 text-sm font-semibold px-3 py-1 rounded-full">-{{ $discount }}%</span>
                    @endif
                </div>

                @if($product->short_description)
                <p class="text-gray-600 mb-8 leading-relaxed">
                    {{ $product->short_description }}
                </p>
                @endif

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <div class="border-t border-b py-6 space-y-6">
                        <!-- Stock Info -->
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Availability:</span>
                                @if($product->in_stock)
                                    <span class="text-sm font-semibold text-green-600 ml-2">In Stock ({{ $product->quantity }} available)</span>
                                @else
                                    <span class="text-sm font-semibold text-red-600 ml-2">Out of Stock</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">SKU:</span>
                                <span class="text-sm font-semibold ml-2">{{ $product->sku ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <div class="text-sm font-medium text-gray-600 mb-3">Quantity</div>
                            <div class="inline-flex items-center bg-gray-100 rounded-full">
                                <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-200 rounded-full transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <input type="number" name="quantity" x-model="quantity" min="1" max="{{ $product->quantity }}" class="w-16 text-center font-medium bg-transparent border-0 focus:outline-none">
                                <button type="button" @click="quantity = Math.min({{ $product->quantity }}, quantity + 1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-200 rounded-full transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-8">
                        <button type="submit" {{ $product->in_stock ? '' : 'disabled' }} class="flex-1 bg-black text-white py-4 rounded-full font-medium hover:bg-gray-800 transition flex items-center justify-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            {{ $product->in_stock ? 'Add to Cart' : 'Out of Stock' }}
                        </button>
                        <button type="button" class="w-14 h-14 border-2 border-gray-200 rounded-full flex items-center justify-center hover:border-gray-300 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Delivery Info -->
                <div class="mt-8 bg-gray-50 rounded-2xl p-6 space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium mb-1">Free Delivery</h4>
                            <p class="text-sm text-gray-600">Free delivery on orders over ZMW 100</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium mb-1">Return Delivery</h4>
                            <p class="text-sm text-gray-600">Free 30 Days Delivery Returns. <a href="#" class="underline">Details</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="mb-16">
            <div class="border-b mb-8">
                <div class="flex gap-8">
                    <button @click="activeTab = 'details'" :class="activeTab === 'details' ? 'border-b-2 border-black' : 'text-gray-500'" class="pb-4 font-medium">Product Details</button>
                    <button @click="activeTab = 'reviews'" :class="activeTab === 'reviews' ? 'border-b-2 border-black' : 'text-gray-500'" class="pb-4 font-medium">Rating & Reviews</button>
                    <button @click="activeTab = 'faqs'" :class="activeTab === 'faqs' ? 'border-b-2 border-black' : 'text-gray-500'" class="pb-4 font-medium">FAQs</button>
                </div>
            </div>

            <!-- Product Details Tab -->
            <div x-show="activeTab === 'details'" class="prose max-w-none">
                <h3 class="text-xl font-semibold mb-4">Product Details</h3>
                @if($product->description)
                    <div class="text-gray-700 leading-relaxed mb-6">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                @endif
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-medium mb-3">Product Information</h4>
                        <ul class="space-y-2 text-gray-600">
                            <li><span class="font-medium">Category:</span> {{ $product->category->name }}</li>
                            <li><span class="font-medium">Vendor:</span> {{ $product->vendor->shop_name }}</li>
                            <li><span class="font-medium">SKU:</span> {{ $product->sku ?? 'N/A' }}</li>
                            <li><span class="font-medium">Stock:</span> {{ $product->quantity }} units</li>
                            @if($product->compare_price)
                                <li><span class="font-medium">You save:</span> ZMW {{ number_format($product->compare_price - $product->price, 2) }}</li>
                            @endif
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-medium mb-3">Shipping & Returns</h4>
                        <ul class="space-y-2 text-gray-600">
                            <li>• Free shipping on orders over ZMW 100</li>
                            <li>• 30-day return policy</li>
                            <li>• Standard delivery: 3-5 business days</li>
                            <li>• Express delivery available</li>
                            <li>• Secure payment options</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div x-show="activeTab === 'reviews'">
                <div class="grid lg:grid-cols-3 gap-12">
                    <!-- Rating Summary -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4">All Reviews</h3>
                        <div class="bg-gray-50 rounded-2xl p-6 text-center">
                            <div class="text-5xl font-bold mb-2">{{ number_format($product->average_rating, 1) }}</div>
                            <div class="flex justify-center text-yellow-400 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->average_rating))
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    @else
                                        <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <div class="text-sm text-gray-600">Based on {{ $product->review_count }} {{ Str::plural('review', $product->review_count) }}</div>
                        </div>

                        <!-- Rating Breakdown -->
                        @php
                            $ratingBreakdown = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                            foreach($product->reviews as $review) {
                                $ratingBreakdown[$review->rating]++;
                            }
                        @endphp
                        <div class="mt-6 space-y-3">
                            @foreach([5, 4, 3, 2, 1] as $rating)
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium">{{ $rating }}</span>
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    @php
                                        $percentage = $product->review_count > 0 ? ($ratingBreakdown[$rating] / $product->review_count) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-yellow-400" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600">{{ $ratingBreakdown[$rating] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="lg:col-span-2 space-y-6">
                        @forelse($product->reviews->take(10) as $review)
                        <div class="border-b pb-6">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="flex text-yellow-400 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                            @else
                                                <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="font-medium">{{ $review->user->name }}</div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 mb-3">{{ $review->comment }}</p>
                        </div>
                        @empty
                        <div class="text-center py-12 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <p>No reviews yet. Be the first to review this product!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- FAQs Tab -->
            <div x-show="activeTab === 'faqs'" class="space-y-4">
                <div class="border rounded-2xl p-6">
                    <h4 class="font-medium mb-2">What is the return policy?</h4>
                    <p class="text-gray-600">We offer a 30-day return policy for all unworn items with original tags attached.</p>
                </div>
                <div class="border rounded-2xl p-6">
                    <h4 class="font-medium mb-2">How long does shipping take?</h4>
                    <p class="text-gray-600">Standard shipping takes 3-5 business days. Express shipping is available for 1-2 business days delivery.</p>
                </div>
                <div class="border rounded-2xl p-6">
                    <h4 class="font-medium mb-2">Is this suitable for running?</h4>
                    <p class="text-gray-600">Yes, these shoes are specifically designed for running with enhanced cushioning and support.</p>
                </div>
            </div>
        </div>

        <!-- You Might Also Like -->
        @if($relatedProducts->count() > 0)
        <div>
            <h2 class="text-3xl font-bold mb-8">You Might Also Like</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <a href="{{ route('products.show', $relatedProduct) }}" class="group cursor-pointer">
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-4">
                        @if($relatedProduct->images && count($relatedProduct->images) > 0)
                            <img src="{{ $relatedProduct->images[0] }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @endif
                    </div>
                    <h3 class="font-semibold mb-1">{{ Str::limit($relatedProduct->name, 30) }}</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold">ZMW {{ number_format($relatedProduct->price, 2) }}</span>
                        @if($relatedProduct->compare_price && $relatedProduct->compare_price > $relatedProduct->price)
                            <span class="text-sm text-gray-400 line-through">ZMW {{ number_format($relatedProduct->compare_price, 2) }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-1 mt-1">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($relatedProduct->average_rating))
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                @else
                                    <svg class="w-3 h-3 fill-current text-gray-300" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500">({{ $relatedProduct->review_count }})</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 pt-16 pb-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-12">
                <div class="col-span-2">
                    <h3 class="text-2xl font-bold mb-4">ShopHub</h3>
                    <p class="text-gray-600 mb-6">We have clothes that suits your style and which you're proud to wear. From women to men.</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-200 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
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

            <div class="border-t pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                <p>ShopHub © 2000-{{ date('Y') }}, All Rights Reserved</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa" class="h-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" class="h-6">
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>
