@extends('layouts.vendor')

@section('page-title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ $vendor->shop_name }}!</h1>
    <p class="text-gray-600">Here's what's happening with your store today.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Products -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-50 rounded-xl">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['total_products'] }}</p>
        <p class="text-sm text-gray-600">Total Products</p>
        <p class="text-xs text-green-600 mt-2">{{ $stats['active_products'] }} active</p>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-50 rounded-xl">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['total_orders'] }}</p>
        <p class="text-sm text-gray-600">Total Orders</p>
        <p class="text-xs text-orange-600 mt-2">{{ $stats['pending_orders'] }} pending</p>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-yellow-50 rounded-xl">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900 mb-1">ZMW {{ number_format($stats['total_revenue'], 0) }}</p>
        <p class="text-sm text-gray-600">Total Revenue</p>
    </div>

    <!-- Commission Rate -->
    <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl shadow-sm p-6 text-white hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-white/20 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold mb-1">{{ $vendor->commission_rate }}%</p>
        <p class="text-sm text-white/90">Commission Rate</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('vendor.products.create') }}" class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md hover:border-blue-200 transition">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-50 group-hover:bg-blue-100 rounded-xl transition">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Add New Product</h3>
                <p class="text-sm text-gray-600">List a new item in your store</p>
            </div>
        </div>
    </a>

    <a href="{{ route('vendor.products.index') }}" class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md hover:border-green-200 transition">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-green-50 group-hover:bg-green-100 rounded-xl transition">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Manage Products</h3>
                <p class="text-sm text-gray-600">View and edit your listings</p>
            </div>
        </div>
    </a>

    <a href="{{ route('vendor.orders.index') }}" class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md hover:border-purple-200 transition">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-purple-50 group-hover:bg-purple-100 rounded-xl transition">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">View Orders</h3>
                <p class="text-sm text-gray-600">Manage customer orders</p>
            </div>
        </div>
    </a>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Order#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Qty</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($stats['recent_orders'] as $orderItem)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900">{{ $orderItem->order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-900">{{ $orderItem->product_name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $orderItem->quantity }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-900">ZMW {{ number_format($orderItem->total, 0) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $orderItem->created_at->format('M d, Y') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-gray-500 font-medium mb-1">No orders yet</p>
                            <p class="text-sm text-gray-400">Your recent orders will appear here</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
