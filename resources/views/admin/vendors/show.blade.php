<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Details - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }">
    @include('admin.layouts.sidebar')

    <div class="lg:pl-64">
        @include('admin.layouts.header')

        <main class="p-6">
            <!-- Back Button & Header -->
            <div class="mb-6">
                <a href="{{ route('admin.vendors.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Vendors
                </a>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        @if($vendor->logo)
                            <img src="{{ asset('storage/' . $vendor->logo) }}" alt="{{ $vendor->shop_name }}" class="w-20 h-20 rounded-2xl object-cover">
                        @else
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center text-white font-bold text-3xl">
                                {{ strtoupper(substr($vendor->shop_name, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold">{{ $vendor->shop_name }}</h1>
                            <p class="text-gray-600 mt-1">{{ $vendor->user->name }} • {{ $vendor->user->email }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                @if($vendor->is_approved)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Approved</span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pending Approval</span>
                                @endif
                                <span class="text-sm text-gray-500">Commission: {{ $vendor->commission_rate }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="px-6 py-3 border border-gray-300 rounded-full font-medium hover:bg-gray-50 transition">
                            Edit Vendor
                        </a>
                        @if(!$vendor->is_approved)
                        <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-full font-medium hover:bg-green-700 transition">
                                Approve Vendor
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Products</h3>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $stats['total_products'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $stats['active_products'] }} active</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Orders</h3>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $stats['total_orders'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $stats['pending_orders'] }} pending</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Revenue</h3>
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">ZMW {{ number_format($stats['total_revenue'], 2) }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $vendor->commission_rate }}% commission</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Average Rating</h3>
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ number_format($stats['avg_rating'] ?? 0, 1) }}</p>
                    <p class="text-sm text-gray-600 mt-1">Out of 5.0</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Store Information -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Store Information</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">Shop Name</p>
                                <p class="font-semibold mt-1">{{ $vendor->shop_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Owner Name</p>
                                <p class="font-semibold mt-1">{{ $vendor->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-semibold mt-1">{{ $vendor->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="font-semibold mt-1">{{ $vendor->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Commission Rate</p>
                                <p class="font-semibold mt-1">{{ $vendor->commission_rate }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Joined Date</p>
                                <p class="font-semibold mt-1">{{ $vendor->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @if($vendor->description)
                        <div class="mt-6 pt-6 border-t">
                            <p class="text-sm text-gray-600 mb-2">Shop Description</p>
                            <p class="text-gray-800">{{ $vendor->description }}</p>
                        </div>
                        @endif
                        @if($vendor->address)
                        <div class="mt-6 pt-6 border-t">
                            <p class="text-sm text-gray-600 mb-2">Address</p>
                            <p class="text-gray-800">{{ $vendor->address }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Products -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold">Products ({{ $vendor->products->count() }})</h2>
                            <a href="{{ route('admin.products.index') }}?vendor={{ $vendor->id }}" class="text-sm text-black hover:underline">View All</a>
                        </div>
                        @if($vendor->products->count() > 0)
                            <div class="space-y-4">
                                @foreach($vendor->products->take(5) as $product)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                    <div class="flex items-center gap-4 flex-1">
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg"></div>
                                        <div class="flex-1">
                                            <p class="font-semibold">{{ $product->name }}</p>
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="text-sm text-gray-600">{{ $product->category->name }}</span>
                                                @if($product->is_active)
                                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">Inactive</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold">ZMW {{ number_format($product->price, 2) }}</p>
                                        <p class="text-sm text-gray-600">Stock: {{ $product->quantity }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <p class="text-sm">No products yet</p>
                            </div>
                        @endif
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold">Recent Orders ({{ $orders->count() }})</h2>
                        </div>
                        @if($orders->count() > 0)
                            <div class="space-y-4">
                                @foreach($orders as $order)
                                <div class="p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold hover:underline">{{ $order->order_number }}</a>
                                            @if($order->status === 'pending')
                                                <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">Pending</span>
                                            @elseif($order->status === 'processing')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Processing</span>
                                            @elseif($order->status === 'shipped')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Shipped</span>
                                            @elseif($order->status === 'delivered')
                                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Delivered</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Cancelled</span>
                                            @endif
                                        </div>
                                        <p class="font-bold">ZMW {{ number_format($order->items->where('vendor_id', $vendor->id)->sum('total'), 2) }}</p>
                                    </div>
                                    <p class="text-sm text-gray-600">Customer: {{ $order->user->name }} • {{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $order->items->where('vendor_id', $vendor->id)->count() }} items from this vendor</p>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <p class="text-sm">No orders yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="{{ route('admin.vendors.edit', $vendor) }}" class="block px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition text-center">
                                Edit Information
                            </a>
                            @if($vendor->is_approved)
                            <form action="{{ route('admin.vendors.reject', $vendor) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 border border-red-300 text-red-600 rounded-xl text-sm font-medium hover:bg-red-50 transition">
                                    Suspend Vendor
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition">
                                    Approve Vendor
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <!-- Financial Summary -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Financial Summary</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-sm text-gray-600">Total Revenue</span>
                                <span class="font-bold">ZMW {{ number_format($stats['total_revenue'], 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-sm text-gray-600">Commission ({{ $vendor->commission_rate }}%)</span>
                                <span class="font-bold">ZMW {{ number_format($stats['total_revenue'] * ($vendor->commission_rate / 100), 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Vendor Earnings</span>
                                <span class="font-bold text-green-600">ZMW {{ number_format($stats['total_revenue'] * (1 - $vendor->commission_rate / 100), 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Timeline -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Recent Activity</h2>
                        <div class="space-y-4">
                            @if($orders->count() > 0)
                                @foreach($orders->take(3) as $order)
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">New order {{ $order->order_number }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            @if($vendor->products->count() > 0)
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">{{ $vendor->products->count() }} products listed</p>
                                        <p class="text-xs text-gray-500">{{ $vendor->products->first()->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">Vendor {{ $vendor->is_approved ? 'approved' : 'registered' }}</p>
                                    <p class="text-xs text-gray-500">{{ $vendor->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

