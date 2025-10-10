@extends('layouts.app')

@section('title', 'Payment')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Complete Payment</h1>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Details</h2>
        <div class="space-y-2">
            <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Order Number:</span> {{ $order->order_number }}</p>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Total Amount:</span> <span class="text-2xl font-bold text-blue-600">₦{{ number_format($order->total, 2) }}</span></p>
            <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Status:</span> {{ ucfirst($order->status) }}</p>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Payment Method</h2>
        
        <div class="mb-6">
            <p class="text-gray-600 dark:text-gray-400 mb-4">Pay with Mobile Money via Lenco</p>
        </div>
        
        <form action="{{ route('lenco.initiate') }}" method="POST">
            @csrf
            
            <input type="hidden" name="amount" value="{{ $order->total }}">
            <input type="hidden" name="currency" value="NGN">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country <span class="text-red-500">*</span></label>
                    <select name="country" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="NG">Nigeria</option>
                        <option value="GH">Ghana</option>
                        <option value="KE">Kenya</option>
                        <option value="UG">Uganda</option>
                        <option value="RW">Rwanda</option>
                        <option value="ZM">Zambia</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white" placeholder="234XXXXXXXXX">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Enter phone number with country code (no + sign)</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mobile Money Operator <span class="text-red-500">*</span></label>
                    <select name="operator" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="mtn">MTN</option>
                        <option value="airtel">Airtel</option>
                        <option value="tnm">TNM</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction Fee Bearer</label>
                    <select name="bearer" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="merchant">Merchant (No extra charge)</option>
                        <option value="customer">Customer (Small fee applies)</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="w-full mt-6 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition font-semibold">
                Pay ₦{{ number_format($order->total, 2) }}
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Secure payment powered by Lenco</p>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        <a href="{{ route('customer.orders.show', $order) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            View Order Details
        </a>
    </div>
</div>
@endsection


