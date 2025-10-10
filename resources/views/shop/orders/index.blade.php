@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">My Orders</h1>
    
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Order #{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mt-2 md:mt-0 flex gap-2">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($order->status === 'delivered') bg-green-100 text-green-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                Payment: {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="space-y-3">
                            @foreach($order->items->take(3) as $item)
                                <div class="flex gap-3">
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-md overflow-hidden flex-shrink-0">
                                        @if($item->product->images && count($item->product->images) > 0)
                                            <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900 dark:text-white">₦{{ number_format($item->total, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($order->items->count() > 3)
                                <p class="text-sm text-gray-600 dark:text-gray-400">+ {{ $order->items->count() - 3 }} more item(s)</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">₦{{ number_format($order->total, 2) }}</p>
                        </div>
                        <a href="{{ route('customer.orders.show', $order) }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition font-semibold">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No orders yet</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Start shopping to create your first order!</p>
            <a href="{{ route('products.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection


