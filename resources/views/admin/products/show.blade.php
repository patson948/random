<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Admin</title>
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
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Products
                </a>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gray-100 rounded-2xl"></div>
                        <div>
                            <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                            <p class="text-gray-600 mt-1">{{ $product->vendor->shop_name }} • {{ $product->category->name }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                @if($product->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">Inactive</span>
                                @endif
                                @if($product->is_featured)
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">Featured</span>
                                @endif
                                @if($product->compare_price && $product->compare_price > $product->price)
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">On Sale</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.products.edit', $product) }}" class="px-6 py-3 border border-gray-300 rounded-full font-medium hover:bg-gray-50 transition">
                            Edit Product
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Price</h3>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">ZMW {{ number_format($product->price, 2) }}</p>
                    @if($product->compare_price)
                        <p class="text-sm text-gray-500 line-through mt-1">ZMW {{ number_format($product->compare_price, 2) }}</p>
                    @endif
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Stock</h3>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $product->quantity }}</p>
                    <p class="text-sm {{ $product->quantity < 10 ? 'text-red-600' : 'text-gray-600' }} mt-1">
                        {{ $product->quantity < 10 ? 'Low stock' : 'In stock' }}
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Sold</h3>
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $stats['total_sold'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">Units</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Revenue</h3>
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">ZMW {{ number_format($stats['total_revenue'], 2) }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Rating</h3>
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ number_format($stats['avg_rating'], 1) }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $stats['total_reviews'] }} reviews</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Product Information -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Product Information</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">Product Name</p>
                                <p class="font-semibold mt-1">{{ $product->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">SKU</p>
                                <p class="font-semibold mt-1">{{ $product->sku }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Category</p>
                                <p class="font-semibold mt-1">{{ $product->category->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Vendor</p>
                                <p class="font-semibold mt-1">{{ $product->vendor->shop_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Price</p>
                                <p class="font-semibold mt-1">ZMW {{ number_format($product->price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Stock Quantity</p>
                                <p class="font-semibold mt-1">{{ $product->quantity }} units</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="font-semibold mt-1">{{ $product->is_active ? 'Active' : 'Inactive' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Created</p>
                                <p class="font-semibold mt-1">{{ $product->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t">
                            <p class="text-sm text-gray-600 mb-2">Description</p>
                            <p class="text-gray-800">{{ $product->description }}</p>
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold">Customer Reviews ({{ $product->reviews->count() }})</h2>
                            <div class="flex items-center gap-2">
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($stats['avg_rating']))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm font-semibold">{{ number_format($stats['avg_rating'], 1) }}</span>
                            </div>
                        </div>
                        @if($product->reviews->count() > 0)
                            <div class="space-y-4">
                                @foreach($product->reviews->take(5) as $review)
                                <div class="pb-4 border-b last:border-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <p class="font-semibold">{{ $review->user->name }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="flex text-yellow-400 text-sm">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            ★
                                                        @else
                                                            ☆
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        @if($review->is_approved)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Approved</span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pending</span>
                                        @endif
                                    </div>
                                    @if($review->comment)
                                    <p class="text-sm text-gray-600 mt-2">{{ $review->comment }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <p class="text-sm">No reviews yet</p>
                            </div>
                        @endif
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Recent Orders</h2>
                        @if($product->orderItems->count() > 0)
                            <div class="space-y-3">
                                @foreach($product->orderItems->take(5) as $orderItem)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-xl">
                                    <div>
                                        <a href="{{ route('admin.orders.show', $orderItem->order) }}" class="font-semibold hover:underline">{{ $orderItem->order->order_number }}</a>
                                        <p class="text-sm text-gray-600 mt-1">{{ $orderItem->order->user->name }} • {{ $orderItem->order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold">{{ $orderItem->quantity }} units</p>
                                        <p class="text-sm text-gray-600">ZMW {{ number_format($orderItem->total, 2) }}</p>
                                    </div>
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
                            <a href="{{ route('admin.products.edit', $product) }}" class="block px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition text-center">
                                Edit Product
                            </a>
                            <a href="{{ route('admin.vendors.show', $product->vendor) }}" class="block px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition text-center">
                                View Vendor
                            </a>
                            @if($product->is_active)
                            <form action="{{ route('admin.products.update', $product) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="0">
                                <button type="submit" class="w-full px-4 py-3 border border-red-300 text-red-600 rounded-xl text-sm font-medium hover:bg-red-50 transition">
                                    Deactivate Product
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.products.update', $product) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="1">
                                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition">
                                    Activate Product
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <!-- Performance Metrics -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Performance</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-sm text-gray-600">Units Sold</span>
                                <span class="font-bold">{{ $stats['total_sold'] }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-sm text-gray-600">Total Revenue</span>
                                <span class="font-bold">ZMW {{ number_format($stats['total_revenue'], 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-sm text-gray-600">Average Rating</span>
                                <span class="font-bold">{{ number_format($stats['avg_rating'], 1) }}/5.0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Reviews</span>
                                <span class="font-bold">{{ $stats['total_reviews'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Alert -->
                    @if($product->quantity < 10)
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <h3 class="font-bold text-red-900">Low Stock Alert</h3>
                                <p class="text-sm text-red-700 mt-1">Only {{ $product->quantity }} units remaining. Consider restocking soon.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Product Metadata -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Metadata</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created</span>
                                <span class="font-medium">{{ $product->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Updated</span>
                                <span class="font-medium">{{ $product->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Product ID</span>
                                <span class="font-medium">#{{ $product->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Slug</span>
                                <span class="font-medium text-xs">{{ $product->slug }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

