<!-- Top Bar -->
<header class="sticky top-0 z-40 bg-white border-b">
    <div class="flex items-center justify-between h-16 px-6">
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="flex items-center gap-4 ml-auto">
            <!-- Search -->
            <div class="hidden md:block relative">
                <input type="text" placeholder="Search..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Notifications -->
            @php
                // Get recent pending orders
                $recentOrders = \App\Models\Order::where('status', 'pending')->latest()->take(3)->get();
                
                // Get pending vendor approvals
                $pendingVendors = \App\Models\Vendor::where('is_approved', false)->latest()->take(2)->get();
                
                // Get low stock products
                $lowStockProducts = \App\Models\Product::where('quantity', '<', 10)->where('quantity', '>', 0)->take(2)->get();
                
                // Calculate total notifications
                $notificationCount = $recentOrders->count() + $pendingVendors->count() + $lowStockProducts->count();
            @endphp
            
            <div class="relative" x-data="{ openNotif: false }">
                <button @click="openNotif = !openNotif" class="relative">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($notificationCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">{{ $notificationCount }}</span>
                    @endif
                </button>

                <div x-show="openNotif" @click.away="openNotif = false" x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border">
                    <div class="p-4 border-b">
                        <h3 class="font-semibold">Notifications</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @if($notificationCount > 0)
                            @foreach($recentOrders as $order)
                            <a href="{{ route('admin.orders.show', $order) }}" class="block p-4 hover:bg-gray-50 border-b">
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">New order received</p>
                                        <p class="text-xs text-gray-600 mt-1">Order {{ $order->order_number }} from {{ $order->user->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach

                            @foreach($pendingVendors as $vendor)
                            <a href="{{ route('admin.vendors.edit', $vendor) }}" class="block p-4 hover:bg-gray-50 border-b">
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Vendor pending approval</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $vendor->store_name }} is awaiting approval</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $vendor->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach

                            @foreach($lowStockProducts as $product)
                            <a href="{{ route('admin.products.edit', $product) }}" class="block p-4 hover:bg-gray-50 border-b">
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-orange-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Low stock alert</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $product->name }} - Only {{ $product->quantity }} left</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $product->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        @else
                            <div class="p-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <p class="text-sm">No new notifications</p>
                            </div>
                        @endif
                    </div>
                    @if($notificationCount > 0)
                    <div class="p-3 border-t text-center">
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-black hover:underline font-medium">View All</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gray-900 text-white rounded-full flex items-center justify-center font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border py-2">
                            <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-50">Profile Settings</a>
                            <hr class="my-2">
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Sign Out</button>
                            </form>
                        </div>
            </div>
        </div>
    </div>
</header>

<style>
    [x-cloak] { display: none !important; }
</style>

