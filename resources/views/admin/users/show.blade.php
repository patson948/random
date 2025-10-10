<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details - Admin</title>
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
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Customers
                </a>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white font-bold text-3xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                            <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                @if($user->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">Inactive</span>
                                @endif
                                <span class="text-sm text-gray-500">Member since {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.users.edit', $user) }}" class="px-6 py-3 border border-gray-300 rounded-full font-medium hover:bg-gray-50 transition">
                            Edit Customer
                        </a>
                        <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-3 border border-gray-300 rounded-full font-medium hover:bg-gray-50 transition">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Orders</h3>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $stats['total_orders'] }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Spent</h3>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">₦{{ number_format($stats['total_spent'], 2) }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Pending Orders</h3>
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $stats['pending_orders'] }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Completed</h3>
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $stats['completed_orders'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Customer Information & Addresses -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Account Information -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Account Information</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">Full Name</p>
                                <p class="font-semibold mt-1">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email Address</p>
                                <p class="font-semibold mt-1">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Customer ID</p>
                                <p class="font-semibold mt-1">#{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Member Since</p>
                                <p class="font-semibold mt-1">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Account Status</p>
                                <p class="font-semibold mt-1">
                                    @if($user->is_active)
                                        <span class="text-green-600">Active</span>
                                    @else
                                        <span class="text-gray-600">Inactive</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Last Login</p>
                                <p class="font-semibold mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Addresses -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Shipping Addresses</h2>
                        @if($addresses->count() > 0)
                            <div class="space-y-4">
                                @foreach($addresses as $index => $address)
                                <div class="p-4 border border-gray-200 rounded-xl">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold">{{ $address->name }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $address->phone }}</p>
                                            <p class="text-sm text-gray-600 mt-2">
                                                {{ $address->address }}<br>
                                                {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br>
                                                {{ $address->country }}
                                            </p>
                                        </div>
                                        @if($index === 0)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Primary</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-sm">No addresses on file</p>
                            </div>
                        @endif
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold">Recent Orders</h2>
                            <a href="{{ route('admin.orders.index') }}?customer={{ $user->id }}" class="text-sm text-black hover:underline">View All</a>
                        </div>
                        @if($user->orders->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->orders->take(5) as $order)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                    <div class="flex-1">
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
                                        <p class="text-sm text-gray-600 mt-1">{{ $order->items->count() }} items • {{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold">₦{{ number_format($order->total, 2) }}</p>
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

                <!-- Reviews & Activity -->
                <div class="space-y-6">
                    <!-- Customer Reviews -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Recent Reviews</h2>
                        @if($user->reviews->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->reviews->take(5) as $review)
                                <div class="pb-4 border-b last:border-0">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold">{{ $review->product->name }}</p>
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
                                            @if($review->comment)
                                            <p class="text-sm text-gray-600 mt-2">{{ Str::limit($review->comment, 80) }}</p>
                                            @endif
                                        </div>
                                    </div>
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

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="{{ route('admin.orders.index') }}?customer={{ $user->id }}" class="block px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition text-center">
                                View All Orders
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="block px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition text-center">
                                Edit Information
                            </a>
                            <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                                    {{ $user->is_active ? 'Deactivate Account' : 'Activate Account' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Activity Log -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Recent Activity</h2>
                        <div class="space-y-4">
                            @if($user->orders->count() > 0)
                                @foreach($user->orders->take(3) as $order)
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Placed order {{ $order->order_number }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            @if($user->reviews->count() > 0)
                                @foreach($user->reviews->take(2) as $review)
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Reviewed {{ $review->product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">Account created</p>
                                    <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
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

