@extends('layouts.vendor')

@section('title', 'Orders')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Orders</h1>
            <p class="text-gray-600 mt-1">Manage your customer orders</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="flex gap-4">
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                <div class="text-2xl font-bold text-gray-900">{{ $orderItems->total() }}</div>
                <div class="text-sm text-gray-600">Total Orders</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="status" class="block text-sm font-semibold text-gray-900 mb-2">Filter by Status</label>
                <select 
                    name="status" 
                    id="status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition"
                >
                    <option value="">All Orders</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <div class="flex items-end gap-2">
                <button 
                    type="submit"
                    class="bg-black text-white px-6 py-3 rounded-xl hover:bg-gray-800 transition font-medium"
                >
                    Filter
                </button>
                
                @if(request()->hasAny(['status']))
                    <a 
                        href="{{ route('vendor.orders.index') }}"
                        class="bg-gray-100 text-gray-900 px-6 py-3 rounded-xl hover:bg-gray-200 transition font-medium"
                    >
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($orderItems->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Order</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Customer</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Product</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Quantity</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Price</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($orderItems as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">#{{ $item->order->order_number }}</div>
                                            <div class="text-sm text-gray-600">Order ID: {{ $item->order->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item->order->user->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $item->order->user->email }}</div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($item->product && $item->product->images && count($item->product->images) > 0)
                                            <img 
                                                src="{{ $item->product->images[0] }}" 
                                                alt="{{ $item->product->name }}"
                                                class="w-12 h-12 rounded-xl object-cover"
                                            >
                                        @else
                                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $item->product->name ?? 'Product Deleted' }}</div>
                                            <div class="text-sm text-gray-600">SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">ZMW {{ number_format($item->price, 2) }}</div>
                                    <div class="text-sm text-gray-600">Total: ZMW {{ number_format($item->price * $item->quantity, 2) }}</div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-purple-100 text-purple-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusColor = $statusColors[$item->order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                        {{ ucfirst($item->order->status) }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $item->order->created_at->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-600">{{ $item->order->created_at->format('h:i A') }}</div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <a 
                                        href="{{ route('vendor.orders.show', $item->order) }}"
                                        class="inline-flex items-center gap-2 bg-black text-white px-4 py-2 rounded-xl hover:bg-gray-800 transition font-medium text-sm"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($orderItems->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orderItems->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Orders Found</h3>
                <p class="text-gray-600 mb-6">
                    @if(request()->hasAny(['status']))
                        No orders match your current filters. Try adjusting your search criteria.
                    @else
                        You haven't received any orders yet. Once customers start placing orders, they'll appear here.
                    @endif
                </p>
                @if(request()->hasAny(['status']))
                    <a 
                        href="{{ route('vendor.orders.index') }}"
                        class="inline-flex items-center gap-2 bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800 transition font-medium"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
