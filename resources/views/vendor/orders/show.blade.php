@extends('layouts.vendor')

@section('title', 'Order Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a 
                    href="{{ route('vendor.orders.index') }}"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-black transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Orders
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
            <p class="text-gray-600 mt-1">Order placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
        </div>
        
        <!-- Status Badge -->
        <div>
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                    'delivered' => 'bg-green-100 text-green-800 border-green-200',
                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                ];
                $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold border {{ $statusColor }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Items</h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            @if($item->product && $item->product->images && count($item->product->images) > 0)
                                <img 
                                    src="{{ $item->product->images[0] }}" 
                                    alt="{{ $item->product->name }}"
                                    class="w-16 h-16 rounded-xl object-cover"
                                >
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $item->product->name ?? 'Product Deleted' }}</h3>
                                <p class="text-sm text-gray-600">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</span>
                                    <span class="text-sm text-gray-600">Price: ZMW {{ number_format($item->price, 2) }}</span>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="font-semibold text-gray-900">ZMW {{ number_format($item->price * $item->quantity, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Timeline</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <div>
                            <div class="font-medium text-gray-900">Order Placed</div>
                            <div class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</div>
                        </div>
                    </div>
                    
                    @if($order->status === 'processing' || $order->status === 'shipped' || $order->status === 'delivered')
                        <div class="flex items-center gap-4">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <div>
                                <div class="font-medium text-gray-900">Order Processing</div>
                                <div class="text-sm text-gray-600">Order is being prepared</div>
                            </div>
                        </div>
                    @endif
                    
                    @if($order->status === 'shipped' || $order->status === 'delivered')
                        <div class="flex items-center gap-4">
                            <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                            <div>
                                <div class="font-medium text-gray-900">Order Shipped</div>
                                <div class="text-sm text-gray-600">Order has been shipped</div>
                            </div>
                        </div>
                    @endif
                    
                    @if($order->status === 'delivered')
                        <div class="flex items-center gap-4">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <div>
                                <div class="font-medium text-gray-900">Order Delivered</div>
                                <div class="text-sm text-gray-600">Order has been delivered</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Customer Information</h2>
                
                <div class="space-y-3">
                    <div>
                        <div class="text-sm font-medium text-gray-600">Name</div>
                        <div class="text-gray-900">{{ $order->user->name }}</div>
                    </div>
                    
                    <div>
                        <div class="text-sm font-medium text-gray-600">Email</div>
                        <div class="text-gray-900">{{ $order->user->email }}</div>
                    </div>
                    
                    @if($order->user->phone)
                        <div>
                            <div class="text-sm font-medium text-gray-600">Phone</div>
                            <div class="text-gray-900">{{ $order->user->phone }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Shipping Address</h2>
                
                <div class="space-y-2">
                    <div class="text-gray-900">{{ $order->shipping_address['name'] ?? $order->user->name }}</div>
                    <div class="text-gray-600">{{ $order->shipping_address['address'] ?? 'No address provided' }}</div>
                    @if(isset($order->shipping_address['city']))
                        <div class="text-gray-600">{{ $order->shipping_address['city'] }}</div>
                    @endif
                    @if(isset($order->shipping_address['state']))
                        <div class="text-gray-600">{{ $order->shipping_address['state'] }}</div>
                    @endif
                    @if(isset($order->shipping_address['postal_code']))
                        <div class="text-gray-600">{{ $order->shipping_address['postal_code'] }}</div>
                    @endif
                    @if(isset($order->shipping_address['country']))
                        <div class="text-gray-600">{{ $order->shipping_address['country'] }}</div>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">ZMW {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    
                    @if($order->shipping_cost > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold">ZMW {{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                    @endif
                    
                    @if($order->tax_amount > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-semibold">ZMW {{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                    @endif
                    
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-gray-900">ZMW {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Information</h2>
                
                <div class="space-y-3">
                    <div>
                        <div class="text-sm font-medium text-gray-600">Payment Method</div>
                        <div class="text-gray-900">{{ ucfirst($order->payment_method) }}</div>
                    </div>
                    
                    <div>
                        <div class="text-sm font-medium text-gray-600">Payment Status</div>
                        @php
                            $paymentStatusColors = [
                                'paid' => 'bg-green-100 text-green-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'failed' => 'bg-red-100 text-red-800',
                            ];
                            $paymentStatusColor = $paymentStatusColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium {{ $paymentStatusColor }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
