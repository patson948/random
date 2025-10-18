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
                <a href="/" class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="Olandex" class="h-10 w-auto" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span class="text-xl font-bold hidden">Olandex</span>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/search?category=men" class="text-sm font-medium hover:text-gray-600">Men</a>
                <a href="/search?category=women" class="text-sm font-medium hover:text-gray-600">Women</a>
                <a href="/search?category=kids" class="text-sm font-medium hover:text-gray-600">Kids</a>
                <a href="/search?category=sports" class="text-sm font-medium hover:text-gray-600">Sports</a>
                <a href="{{ route('categories.index') }}" class="text-sm font-medium hover:text-gray-600">Categories</a>
                <a href="/deals" class="text-sm font-medium text-red-600 hover:text-red-700">Sale</a>
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

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @if($cartCount ?? 0 > 0)
                    <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
                    @endif
                </a>

                <!-- User Menu -->
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 border" style="display: none;">
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

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" class="md:hidden pb-4" style="display: none;">
            <div class="space-y-2">
                <a href="/search?category=men" class="block py-2 text-sm font-medium hover:text-gray-600">Men</a>
                <a href="/search?category=women" class="block py-2 text-sm font-medium hover:text-gray-600">Women</a>
                <a href="/search?category=kids" class="block py-2 text-sm font-medium hover:text-gray-600">Kids</a>
                <a href="/search?category=sports" class="block py-2 text-sm font-medium hover:text-gray-600">Sports</a>
                <a href="{{ route('categories.index') }}" class="block py-2 text-sm font-medium hover:text-gray-600">Categories</a>
                <a href="/deals" class="block py-2 text-sm font-medium text-red-600 hover:text-red-700">Sale</a>
            </div>
        </div>
    </div>
</nav>

