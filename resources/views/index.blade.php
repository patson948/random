<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopHub - Your Trusted Marketplace</title>
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
    @if($topBar)
    <div class="bg-gray-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <span>{{ $topBar->title }}</span>
            <div class="flex gap-4">
                <span>Help</span>
                <span>Track Order</span>
            </div>
        </div>
    </div>
    @else
    <div class="bg-gray-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <span>Free shipping on orders over ZMW 50,000</span>
            <div class="flex gap-4">
                <span>Help</span>
                <span>Track Order</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation -->
    @include('components.nav')

    <!-- Hero Slider Section -->
    <section class="relative bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ 
        currentSlide: 0,
        slides: @js($heroSlides),
        autoplay: null,
        init() {
            this.autoplay = setInterval(() => {
                this.next();
            }, 5000);
        },
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        },
        goToSlide(index) {
            this.currentSlide = index;
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <!-- Slides -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="currentSlide === index" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 transform translate-x-10"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform -translate-x-10"
                     class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-block bg-black text-white text-xs font-semibold px-3 py-1 rounded-full mb-4" x-text="slide.badge"></div>
                        <h1 class="text-4xl lg:text-5xl font-bold mb-4 leading-tight" x-text="slide.title"></h1>
                        <p class="text-base text-gray-600 mb-6" x-text="slide.description"></p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a :href="slide.buttonLink" class="bg-black text-white px-8 py-4 rounded-full font-medium hover:bg-gray-800 transition inline-flex items-center justify-center">
                                <span x-text="slide.buttonText"></span>
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            @auth
                                @if(auth()->user()->role === 'customer')
                                <a href="{{ route('dashboard') }}" class="border-2 border-black text-black px-8 py-4 rounded-full font-medium hover:bg-black hover:text-white transition inline-flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    My Dashboard
                                </a>
                                @else
                                <button @click="$dispatch('open-register')" class="border-2 border-black text-black px-8 py-4 rounded-full font-medium hover:bg-black hover:text-white transition">
                                    Sign Up Free
                                </button>
                                @endif
                            @else
                            <button @click="$dispatch('open-register')" class="border-2 border-black text-black px-8 py-4 rounded-full font-medium hover:bg-black hover:text-white transition">
                                Sign Up Free
                            </button>
                            @endauth
                        </div>
                        <div class="mt-8 flex gap-6">
                            <div>
                                <div class="text-2xl font-bold">{{ $stats['vendors'] }}+</div>
                                <div class="text-xs text-gray-600">Trusted Vendors</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">{{ number_format($stats['products']) }}+</div>
                                <div class="text-xs text-gray-600">Quality Products</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">{{ $stats['categories'] }}+</div>
                                <div class="text-xs text-gray-600">Categories</div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="aspect-square bg-gray-200 rounded-3xl overflow-hidden">
                            <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">
                        </div>
                        <!-- Floating Card -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center font-bold">
                                    %
                                </div>
                                <div>
                                    <div class="text-sm font-semibold">Exclusive Offers</div>
                                    <div class="text-xs text-gray-500">Up to 50% OFF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Navigation Arrows -->
            <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4 pointer-events-none">
                <button @click="prev(); clearInterval(autoplay); autoplay = setInterval(() => next(), 5000);" 
                        class="pointer-events-auto w-12 h-12 bg-white/90 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition transform hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="next(); clearInterval(autoplay); autoplay = setInterval(() => next(), 5000);" 
                        class="pointer-events-auto w-12 h-12 bg-white/90 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition transform hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <!-- Dots Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="goToSlide(index); clearInterval(autoplay); autoplay = setInterval(() => next(), 5000);" 
                            :class="currentSlide === index ? 'bg-black w-8' : 'bg-gray-400 w-2'" 
                            class="h-2 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
    </section>

    <!-- Brands Section -->
    <!-- <section class="bg-white py-12 border-y">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-center text-sm font-semibold text-gray-500 uppercase tracking-wider mb-8">Trusted Brands</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
                <a href="/search?brand=versace" class="flex items-center justify-center p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition group">
                    <div class="text-2xl font-bold opacity-50 group-hover:opacity-100 transition">VERSACE</div>
                </a>
                <a href="/search?brand=zara" class="flex items-center justify-center p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition group">
                    <div class="text-2xl font-bold opacity-50 group-hover:opacity-100 transition">ZARA</div>
                </a>
                <a href="/search?brand=gucci" class="flex items-center justify-center p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition group">
                    <div class="text-2xl font-bold opacity-50 group-hover:opacity-100 transition">GUCCI</div>
                </a>
                <a href="/search?brand=prada" class="flex items-center justify-center p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition group">
                    <div class="text-2xl font-bold opacity-50 group-hover:opacity-100 transition">PRADA</div>
                </a>
                <a href="/search?brand=calvin-klein" class="flex items-center justify-center p-6 bg-gray-50 rounded-2xl hover:bg-gray-100 transition group">
                    <div class="text-2xl font-bold opacity-50 group-hover:opacity-100 transition">CALVIN KLEIN</div>
                </a>
            </div>
        </div>
    </section> -->

    <!-- Hot Deals Section -->
    <section class="py-16 bg-gradient-to-br from-red-50 to-orange-50" x-data="{ 
        scrollContainer: null,
        init() {
            this.scrollContainer = this.$refs.dealsContainer;
        },
        scrollLeft() {
            this.scrollContainer.scrollBy({ left: -300, behavior: 'smooth' });
        },
        scrollRight() {
            this.scrollContainer.scrollBy({ left: 300, behavior: 'smooth' });
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <div class="inline-block bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full mb-2">🔥 HOT DEALS</div>
                    <h2 class="text-4xl font-bold">Unbeatable Prices</h2>
                    <p class="text-gray-600 mt-2">Limited time offers - Grab them before they're gone!</p>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Scroll Buttons -->
                    <div class="hidden md:flex gap-2">
                        <button @click="scrollLeft()" class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button @click="scrollRight()" class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                    <a href="/deals" class="text-sm font-medium flex items-center hover:underline">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Horizontal Scrolling Container -->
            <div class="relative">
                <div x-ref="dealsContainer" class="flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory pb-4" style="scroll-padding-left: 1rem;">
                    @forelse($deals as $product)
                    <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition flex-shrink-0 w-48 snap-start">
                        <div class="aspect-square bg-gray-100 overflow-hidden relative">
                            <img src="{{ $product->main_image ?? 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&q=80' }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @if($product->compare_price && $product->compare_price > $product->price)
                                <div class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-3 py-2 rounded-xl shadow-lg">
                                    <div class="text-lg leading-none">{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%</div>
                                    <div class="text-[10px] opacity-90">OFF</div>
                                </div>
                            @endif
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 group-hover:opacity-100 transition">
                                <button class="w-full bg-white text-black py-2 rounded-lg text-xs font-semibold">
                                    Quick View
                                </button>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-bold text-red-600">ZMW {{ number_format($product->price, 0) }}</span>
                            </div>
                            @if($product->compare_price)
                                <div class="text-xs text-gray-500 line-through mt-1">ZMW {{ number_format($product->compare_price, 0) }}</div>
                            @endif
                        </div>
                    </a>
                    @empty
                    <div class="w-full text-center py-8">
                        <p class="text-gray-500">No deals available at the moment.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Custom Scrollbar Hide CSS -->
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </section>

     <!-- Categories Grid -->
     @if($featuredCategories->count() > 0)
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <div class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-2">🏷️ CATEGORIES</div>
                <h2 class="text-4xl font-bold mb-4">Shop by Category</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Browse through your favorite categories. We've got them all!</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($featuredCategories as $category)
                <a href="/search?category={{ strtolower($category->name) }}" class="group">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 text-center hover:from-black hover:to-gray-800 transition-all duration-300">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                            <svg class="w-8 h-8 text-gray-800 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-1 group-hover:text-white transition">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-500 group-hover:text-gray-300 transition">{{ $category->products_count }} items</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- New Arrivals -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <div class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mb-2">✨ JUST IN</div>
                    <h2 class="text-4xl font-bold">New Arrivals</h2>
                </div>
                <a href="/search" class="text-sm font-medium flex items-center hover:underline">
                    View All
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($newArrivals->take(8) as $product)
                <a href="{{ route('products.show', $product) }}" class="group">
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden mb-4 relative">
                        <img src="{{ $product->main_image ?? 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&q=80' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                            NEW
                        </span>
                        <button class="absolute top-3 right-3 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="font-semibold mb-1">{{ Str::limit($product->name, 30) }}</h3>
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
                        @if($product->compare_price)
                            <span class="text-sm text-gray-400 line-through">ZMW {{ number_format($product->compare_price, 0) }}</span>
                        @endif
                    </div>
                </a>
                @empty
                <div class="col-span-4 text-center py-8">
                    <p class="text-gray-500">No new products available yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Fashion Category Products -->
    @if($fashionProducts->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 items-center mb-10">
                <div>
                    <div class="inline-block bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full mb-2">👗 FASHION</div>
                    <h2 class="text-4xl font-bold mb-4">Trending Fashion</h2>
                    <p class="text-gray-600 mb-6">Discover the latest styles and trends that everyone's talking about</p>
                    <a href="/search?category=fashion" class="inline-flex items-center gap-2 bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                        Explore Fashion
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
                <div class="aspect-video bg-purple-100 rounded-3xl overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&q=80" alt="Fashion" class="w-full h-full object-cover">
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($fashionProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition">
                    <div class="aspect-square bg-gray-100 overflow-hidden relative">
                        <img src="{{ $product->main_image ?? 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400&q=80' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold mb-2">{{ Str::limit($product->name, 25) }}</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-lg font-bold">ZMW {{ number_format($product->price, 0) }}</span>
                            @if($product->compare_price)
                                <span class="text-xs text-gray-400 line-through">ZMW {{ number_format($product->compare_price, 0) }}</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

   

    <!-- CTA Banners -->
    @if($ctaBanners->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($ctaBanners->take(2) as $banner)
                <div class="relative bg-gradient-to-br {{ $banner->gradient ?? 'from-indigo-500 to-purple-600' }} rounded-3xl overflow-hidden">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative z-10 p-8 lg:p-12 text-white">
                        @if($banner->badge)
                        <div class="inline-block bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full mb-4">{{ $banner->badge }}</div>
                        @endif
                        <h3 class="text-3xl lg:text-4xl font-bold mb-4">{{ $banner->title }}</h3>
                        @if($banner->description)
                        <p class="mb-6 text-white/90">{{ $banner->description }}</p>
                        @endif
                        @if($banner->button_text && $banner->button_link)
                        <a href="{{ $banner->button_link }}" class="inline-flex items-center gap-2 bg-white text-indigo-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                            {{ $banner->button_text }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                    <div class="absolute bottom-0 right-0 w-1/2 h-1/2 bg-white/10 rounded-tl-full"></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @else
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Banner 1 -->
                <div class="relative bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl overflow-hidden">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative z-10 p-8 lg:p-12 text-white">
                        <div class="inline-block bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full mb-4">LIMITED OFFER</div>
                        <h3 class="text-3xl lg:text-4xl font-bold mb-4">Up to 50% OFF</h3>
                        <p class="mb-6 text-white/90">On selected items this season</p>
                        <a href="/deals" class="inline-flex items-center gap-2 bg-white text-indigo-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                            Shop Now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                    <div class="absolute bottom-0 right-0 w-1/2 h-1/2 bg-white/10 rounded-tl-full"></div>
                </div>

                <!-- Banner 2 -->
                <div class="relative bg-gradient-to-br from-orange-400 to-pink-500 rounded-3xl overflow-hidden">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative z-10 p-8 lg:p-12 text-white">
                        <div class="inline-block bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full mb-4">NEW COLLECTION</div>
                        <h3 class="text-3xl lg:text-4xl font-bold mb-4">Summer Styles</h3>
                        <p class="mb-6 text-white/90">Fresh arrivals for the season</p>
                        <a href="/search" class="inline-flex items-center gap-2 bg-white text-orange-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                            Discover More
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                    <div class="absolute top-0 left-0 w-1/2 h-1/2 bg-white/10 rounded-br-full"></div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-amber-50 to-amber-100 rounded-3xl p-12 lg:p-20 text-center">
                <h2 class="text-4xl lg:text-5xl font-bold mb-4">STAY UPDATED ABOUT OUR LATEST OFFERS</h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Subscribe to our newsletter and get 20% off your first order</p>
                <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" placeholder="Enter your email address" class="flex-1 px-6 py-4 rounded-full border focus:outline-none focus:ring-2 focus:ring-black">
                    <button class="bg-black text-white px-8 py-4 rounded-full font-medium hover:bg-gray-800 transition whitespace-nowrap">
                        Subscribe to Newsletter
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-12">
                <div class="col-span-2">
                    <h3 class="text-2xl font-bold mb-4">olandex</h3>
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
                        @foreach($navCategories->take(3) as $category)
                        <li><a href="/search?category={{ strtolower($category->name) }}" class="hover:text-black">{{ $category->name }}</a></li>
                        @endforeach
                        <li><a href="/search?sale=1" class="hover:text-black">Sale Items</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                <p>olandex © 2000-{{ date('Y') }}, All Rights Reserved</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa" class="h-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6">
                    <img src="https://momo.mtn.com/wp-content/uploads/sites/15/2022/07/Group-360.png?w=360" alt="MTN Mobile Money" class="h-6">
                    <img src="https://www.airtel.africa/sites/default/files/airtel-logo_0.png" alt="Airtel Money" class="h-6">
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>