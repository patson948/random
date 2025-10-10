<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order {{ $order->order_number }} - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Authentication Modals -->
    @include('components.auth-modals')

    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <span>Free shipping on orders over ₦50,000</span>
            <div class="flex gap-4">
                <span>24/7 Customer Support</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white border-b sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-8">
                    <a href="/" class="text-2xl font-bold">ShopHub</a>
                    <div class="hidden md:flex gap-6">
                        <a href="/products" class="text-sm font-medium hover:text-gray-600 transition">Shop</a>
                        <a href="/categories" class="text-sm font-medium hover:text-gray-600 transition">Categories</a>
                        <a href="/deals" class="text-sm font-medium hover:text-gray-600 transition">Deals</a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="/search" class="hidden md:block">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </a>

                    <a href="/cart" class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-black text-white text-xs rounded-full flex items-center justify-center">0</span>
                    </a>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gray-900 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 border">
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="/dashboard" class="block px-4 py-2 text-sm hover:bg-gray-50">Dashboard</a>
                            <a href="/orders" class="block px-4 py-2 text-sm bg-gray-50 font-medium">My Orders</a>
                            <a href="/wishlist" class="block px-4 py-2 text-sm hover:bg-gray-50">Wishlist</a>
                            <a href="/profile" class="block px-4 py-2 text-sm hover:bg-gray-50">Settings</a>
                            <form method="POST" action="/logout" class="border-t mt-2 pt-2">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-50">Sign Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="/orders" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-black mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Orders
            </a>
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Order {{ $order->order_number }}</h1>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
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
                <button onclick="downloadReceipt()" class="px-6 py-3 bg-black text-white rounded-full font-medium hover:bg-gray-800 transition">
                    Download Receipt
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-4">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-start gap-4 pb-4 border-b last:border-0">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0"></div>
                            <div class="flex-1">
                                <h3 class="font-semibold">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $item->product->category->name }}</p>
                                <p class="text-sm text-gray-600">Sold by {{ $item->vendor->store_name }}</p>
                                <p class="text-sm text-gray-600 mt-2">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">₦{{ number_format($item->total, 2) }}</p>
                                <p class="text-sm text-gray-600">₦{{ number_format($item->price, 2) }} each</p>
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

                <!-- Delivery Tracking -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-4">Delivery Status</h2>
                    <div class="relative">
                        <!-- Timeline -->
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">Order Confirmed</p>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>

                            @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">Order Processing</p>
                                    <p class="text-sm text-gray-600">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if(in_array($order->status, ['shipped', 'delivered']))
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">Order Shipped</p>
                                    <p class="text-sm text-gray-600">In transit to your address</p>
                                </div>
                            </div>
                            @endif

                            @if($order->status == 'delivered')
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold">Delivered</p>
                                    <p class="text-sm text-gray-600">Order has been delivered</p>
                                </div>
                            </div>
                            @elseif($order->status != 'cancelled')
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-400">Awaiting Delivery</p>
                                    <p class="text-sm text-gray-400">Pending</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-4">Shipping Address</h2>
                    @php
                        $address = json_decode($order->shipping_address);
                    @endphp
                    <div class="space-y-1 text-sm">
                        <p class="font-semibold">{{ $address->name }}</p>
                        <p class="text-gray-600">{{ $address->phone }}</p>
                        <p class="text-gray-600">{{ $address->address }}</p>
                        <p class="text-gray-600">{{ $address->city }}, {{ $address->state }}</p>
                        <p class="text-gray-600">{{ $address->country }} - {{ $address->postal_code }}</p>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-4">Payment Information</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Payment Method</span>
                            <span class="font-semibold">{{ ucfirst($order->payment_method) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Payment Status</span>
                            <span class="px-2 py-1 {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-700' }} text-xs font-medium rounded-full">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm pt-3 border-t">
                            <span class="text-gray-600">Total Paid</span>
                            <span class="font-bold text-lg">₦{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($order->notes)
                <!-- Order Notes -->
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        <div>
                            <h3 class="font-bold text-blue-900 text-sm">Your Note</h3>
                            <p class="text-sm text-blue-700 mt-1">{{ $order->notes }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-4">Need Help?</h2>
                    <div class="space-y-3">
                        <a href="/contact" class="block px-4 py-3 border border-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 transition text-center">
                            Contact Support
                        </a>
                        @if($order->status == 'delivered')
                        <button class="w-full px-4 py-3 bg-black text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition">
                            Review Items
                        </button>
                        @endif
                        @if(in_array($order->status, ['pending', 'processing']))
                        <button class="w-full px-4 py-3 border border-red-300 text-red-600 rounded-xl text-sm font-medium hover:bg-red-50 transition">
                            Cancel Order
                        </button>
                        @endif
                    </div>
                </div>

                <!-- QR Code for Receipt -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 text-center">
                    <h3 class="font-bold mb-3">Order QR Code</h3>
                    <div id="qrcode" class="flex justify-center mb-3"></div>
                    <p class="text-xs text-gray-600">Scan to view order details</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Hidden Receipt Template -->
    <div id="receipt-template" style="display: none;">
        <div style="padding: 40px; font-family: Arial, sans-serif;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="font-size: 28px; margin-bottom: 10px;">ShopHub</h1>
                <p style="color: #666;">Order Receipt</p>
            </div>

            <div style="margin-bottom: 30px;">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>

            <div style="margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px;">Items</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #000;">
                            <th style="text-align: left; padding: 10px;">Item</th>
                            <th style="text-align: center; padding: 10px;">Qty</th>
                            <th style="text-align: right; padding: 10px;">Price</th>
                            <th style="text-align: right; padding: 10px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 10px;">{{ $item->product->name }}</td>
                            <td style="text-align: center; padding: 10px;">{{ $item->quantity }}</td>
                            <td style="text-align: right; padding: 10px;">₦{{ number_format($item->price, 2) }}</td>
                            <td style="text-align: right; padding: 10px;">₦{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-bottom: 30px; text-align: right;">
                <p><strong>Subtotal:</strong> ₦{{ number_format($order->subtotal, 2) }}</p>
                <p><strong>Tax:</strong> ₦{{ number_format($order->tax, 2) }}</p>
                <p><strong>Shipping:</strong> ₦{{ number_format($order->shipping, 2) }}</p>
                <p style="font-size: 18px; margin-top: 10px;"><strong>Total:</strong> ₦{{ number_format($order->total, 2) }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <h3 style="margin-bottom: 10px;">Shipping Address</h3>
                <p>{{ $address->name }}</p>
                <p>{{ $address->phone }}</p>
                <p>{{ $address->address }}</p>
                <p>{{ $address->city }}, {{ $address->state }}</p>
                <p>{{ $address->country }} - {{ $address->postal_code }}</p>
            </div>

            <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd;">
                <p style="color: #666; font-size: 12px;">Thank you for shopping with ShopHub!</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">ShopHub</h3>
                    <p class="text-gray-400 text-sm">Your one-stop shop for everything you need.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/products" class="hover:text-white">All Products</a></li>
                        <li><a href="/categories" class="hover:text-white">Categories</a></li>
                        <li><a href="/deals" class="hover:text-white">Deals</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Account</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/dashboard" class="hover:text-white">Dashboard</a></li>
                        <li><a href="/orders" class="hover:text-white">Orders</a></li>
                        <li><a href="/wishlist" class="hover:text-white">Wishlist</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/contact" class="hover:text-white">Contact Us</a></li>
                        <li><a href="/faq" class="hover:text-white">FAQ</a></li>
                        <li><a href="/shipping" class="hover:text-white">Shipping Info</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; 2025 ShopHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Generate QR Code
        const orderUrl = window.location.href;
        new QRCode(document.getElementById("qrcode"), {
            text: orderUrl,
            width: 128,
            height: 128
        });

        // Download Receipt as PDF
        function downloadReceipt() {
            const element = document.getElementById('receipt-template');
            const opt = {
                margin: 10,
                filename: 'order-{{ $order->order_number }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>

