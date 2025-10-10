@extends('layouts.app')

@section('title', 'Order Placed Successfully')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <div class="mb-6">
            <svg class="mx-auto h-20 w-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Order Placed Successfully!</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Thank you for your purchase. Your order has been confirmed and will be processed soon.</p>
        
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Order Number</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
        </div>
        
        <div class="space-y-2 text-gray-700 dark:text-gray-300 mb-6">
            <p><span class="font-semibold">Total Amount:</span> ₦{{ number_format($order->total, 2) }}</p>
            <p><span class="font-semibold">Payment Status:</span> <span class="text-green-600 font-semibold">{{ ucfirst($order->payment_status) }}</span></p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.orders.show', $order) }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                View Order Details
            </a>
            <a href="{{ route('products.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white px-6 py-3 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition font-semibold">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection


