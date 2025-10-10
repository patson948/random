<!-- Top Bar -->
<div class="bg-gray-900 text-white text-xs py-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <span>Free shipping on orders over ZMW 50,000</span>
        <div class="flex gap-4">
            <a href="#" class="hover:underline">Help</a>
            <a href="#" class="hover:underline">Track Order</a>
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
                <a href="/search?category=men" class="text-sm font-medium hover:text-gray-600">Men</a>
                <a href="/search?category=women" class="text-sm font-medium hover:text-gray-600">Women</a>
                <a href="/search?category=kids" class="text-sm font-medium hover:text-gray-600">Kids</a>
                <a href="/search?category=sports" class="text-sm font-medium hover:text-gray-600">Sports</a>
                <a href="/products" class="text-sm font-medium hover:text-gray-600">Brands</a>
                <a href="/deals" class="text-sm font-medium text-red-600 hover:text-red-700">Sale</a>
            </div>

            <div class="flex items-center space-x-6">
                <div class="hidden lg:block relative">
                    <form action="{{ route('search') }}" method="GET">
                        <input type="text" name="q" placeholder="Search products..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </form>
                </div>

                <a href="{{ route('cart.index') }}" class="relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @php
                        $cartCount = 0;
                        if (auth()->check()) {
                            $cartCount = auth()->user()->cartItems()->sum('quantity');
                        } else {
                            $sessionCart = session('cart', []);
                            $cartCount = array_sum(array_column($sessionCart, 'quantity'));
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border"
                             style="display: none;">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('customer.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                            <a href="{{ route('customer.addresses.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Addresses</a>
                            <a href="{{ route('customer.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-gray-600">Login</a>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" class="md:hidden pb-4" style="display: none;">
            <div class="space-y-2">
                <a href="/search?category=men" class="block py-2 text-sm font-medium hover:text-gray-600">Men</a>
                <a href="/search?category=women" class="block py-2 text-sm font-medium hover:text-gray-600">Women</a>
                <a href="/search?category=kids" class="block py-2 text-sm font-medium hover:text-gray-600">Kids</a>
                <a href="/search?category=sports" class="block py-2 text-sm font-medium hover:text-gray-600">Sports</a>
                <a href="/products" class="block py-2 text-sm font-medium hover:text-gray-600">Brands</a>
                <a href="/deals" class="block py-2 text-sm font-medium text-red-600 hover:text-red-700">Sale</a>
            </div>
        </div>
    </div>
</nav>

