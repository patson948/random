@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Shopping Cart</h1>
    
    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex gap-4">
                        <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-md overflow-hidden flex-shrink-0">
                            @if($item->product->images && count($item->product->images) > 0)
                                <img src="{{ $item->product->images[0] }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">by {{ $item->product->vendor->shop_name }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">₦{{ number_format($item->product->price, 2) }}</p>
                        </div>
                        
                        <div class="flex flex-col items-end justify-between">
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                            
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" class="w-16 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white text-center">
                                <button type="submit" class="text-sm bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                                    Update
                                </button>
                            </form>
                            
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                ₦{{ number_format($item->product->price * $item->quantity, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
                
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Clear Cart</button>
                </form>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Subtotal</span>
                            <span>₦{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Tax (7.5%)</span>
                            <span>₦{{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Shipping</span>
                            <span>₦{{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 flex justify-between text-xl font-bold text-gray-900 dark:text-white">
                            <span>Total</span>
                            <span>₦{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    
                    @auth
                        <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-600 text-white text-center px-6 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                            Proceed to Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white text-center px-6 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                            Login to Checkout
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Your cart is empty</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Start shopping to add items to your cart!</p>
            <a href="{{ route('products.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection


