@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Order Details</h1>
        <a href="{{ route('customer.orders.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Orders</a>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Order Number</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Date</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            @if($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Payment Status</p>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            @if($order->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Items</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-md overflow-hidden flex-shrink-0">
                                @if($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $item->product_name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Vendor: {{ $item->vendor->shop_name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 dark:text-white">₦{{ number_format($item->total, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Shipping Address</h2>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $order->shipping_address }}</p>
                @if($order->notes)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Order Notes:</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Subtotal</span>
                        <span>₦{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Tax</span>
                        <span>₦{{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Shipping</span>
                        <span>₦{{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-3 flex justify-between text-xl font-bold text-gray-900 dark:text-white">
                        <span>Total</span>
                        <span>₦{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
                
                @if($order->payment_status === 'pending')
                    <a href="{{ route('checkout.payment', $order) }}" class="block w-full mt-6 bg-blue-600 text-white text-center px-6 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                        Complete Payment
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


