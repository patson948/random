<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin</title>
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
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Orders
                </a>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Order {{ $order->order_number }}</h1>
                        <p class="text-gray-600 mt-1">Placed {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                        <div class="flex items-center gap-2 mt-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-purple-100 text-purple-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $paymentColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'paid' => 'bg-green-100 text-green-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                    'refunded' => 'bg-gray-100 text-gray-700',
                                ];
                            @endphp
                            <span class="px-3 py-1 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }} text-xs font-medium rounded-full">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="px-3 py-1 {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-700' }} text-xs font-medium rounded-full">
                                Payment: {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
            @endif

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Amount</h3>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">₦{{ number_format($order->total, 2) }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Items</h3>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $stats['items_count'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $stats['total_quantity'] }} units</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Vendors</h3>
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">{{ $stats['unique_vendors'] }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Payment Method</h3>
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold">{{ ucfirst($order->payment_method) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Items -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Order Items</h2>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-start gap-4 p-4 border border-gray-200 rounded-xl">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0"></div>
                                <div class="flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <a href="{{ route('admin.products.show', $item->product) }}" class="font-semibold hover:underline">{{ $item->product->name }}</a>
                                            <p class="text-sm text-gray-600 mt-1">{{ $item->product->category->name }}</p>
                                            <p class="text-sm text-gray-600">
                                                <a href="{{ route('admin.vendors.show', $item->vendor) }}" class="hover:underline">{{ $item->vendor->store_name }}</a>
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold">₦{{ number_format($item->total, 2) }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} × ₦{{ number_format($item->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Order Summary -->
                        <div class="mt-6 pt-6 border-t space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">₦{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax (7.5%)</span>
                                <span class="font-semibold">₦{{ number_format($order->tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold">₦{{ number_format($order->shipping, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold pt-2 border-t">
                                <span>Total</span>
                                <span>₦{{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Customer Information</h2>
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold text-xl flex-shrink-0">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <a href="{{ route('admin.users.show', $order->user) }}" class="font-semibold text-lg hover:underline">{{ $order->user->name }}</a>
                                <p class="text-gray-600">{{ $order->user->email }}</p>
                                <div class="mt-3 flex gap-3">
                                    <a href="{{ route('admin.users.show', $order->user) }}" class="text-sm text-black hover:underline">View Profile</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="mailto:{{ $order->user->email }}" class="text-sm text-black hover:underline">Send Email</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Shipping Address</h2>
                        @php
                            $address = json_decode($order->shipping_address);
                        @endphp
                        <div class="space-y-1">
                            <p class="font-semibold">{{ $address->name }}</p>
                            <p class="text-gray-600">{{ $address->phone }}</p>
                            <p class="text-gray-600">{{ $address->address }}</p>
                            <p class="text-gray-600">{{ $address->city }}, {{ $address->state }}</p>
                            <p class="text-gray-600">{{ $address->country }} - {{ $address->postal_code }}</p>
                        </div>
                    </div>

                    @if($order->notes)
                    <!-- Order Notes -->
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            <div>
                                <h3 class="font-bold text-blue-900">Customer Notes</h3>
                                <p class="text-sm text-blue-700 mt-1">{{ $order->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Update Status -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Update Status</h2>
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <label class="block text-sm font-medium mb-2">Order Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Payment Status</label>
                                <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-black text-white py-3 rounded-full font-semibold hover:bg-gray-800 transition">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Order Timeline -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Order Timeline</h2>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div>
                                    <p class="text-sm font-semibold">Order Placed</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            
                            @if($order->status != 'pending')
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div>
                                    <p class="text-sm font-semibold">Status: {{ ucfirst($order->status) }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($order->payment_status == 'paid')
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div>
                                    <p class="text-sm font-semibold">Payment Confirmed</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst($order->payment_method) }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Metadata -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Order Information</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order ID</span>
                                <span class="font-medium">#{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Number</span>
                                <span class="font-medium">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created</span>
                                <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Updated</span>
                                <span class="font-medium">{{ $order->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100">
                        <h2 class="text-lg font-bold mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <button onclick="window.print()" class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                                Print Order
                            </button>
                            <a href="mailto:{{ $order->user->email }}" class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition text-center">
                                Email Customer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
