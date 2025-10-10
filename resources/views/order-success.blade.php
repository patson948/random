<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @media print {
            body * { visibility: hidden; }
            #receipt-content, #receipt-content * { visibility: visible; }
            #receipt-content { position: absolute; left: 0; top: 0; width: 100%; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Simplified Header -->
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-2xl font-bold">ShopHub</a>
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    <span class="font-medium">Order Confirmed</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{
        orderNumber: '{{ $order->order_number }}',
        orderDate: '{{ $order->created_at->format('F j, Y') }}',
        estimatedDelivery: '{{ $order->created_at->addDays(5)->format('F j, Y') }}',
        init() {
            this.$nextTick(() => {
                new QRCode(document.getElementById('qrcode'), {
                    text: 'ORDER:' + this.orderNumber,
                    width: 128,
                    height: 128
                });
            });
        },
        downloadReceipt() {
            const element = document.getElementById('receipt-content');
            const opt = {
                margin: 10,
                filename: 'ShopHub-Receipt-' + this.orderNumber + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    }">
        <!-- Success Message -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
                <svg class="w-10 h-10 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-3">Order Placed Successfully!</h1>
            <p class="text-xl text-gray-600 mb-2">Thank you for your purchase</p>
            <p class="text-gray-500">A confirmation email has been sent to your email address</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-2xl shadow-sm p-8 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 pb-8 border-b">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Order Number</p>
                    <p class="text-2xl font-bold" x-text="orderNumber"></p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-sm text-gray-600 mb-1">Order Date</p>
                    <p class="font-semibold" x-text="orderDate"></p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Delivery Info -->
                <div>
                    <h3 class="font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Delivery Address
                    </h3>
                    <p class="text-gray-700 leading-relaxed">
                        @php
                            $shippingAddress = json_decode($order->shipping_address, true);
                        @endphp
                        {{ $shippingAddress['name'] ?? 'N/A' }}<br>
                        {{ $shippingAddress['address'] ?? 'N/A' }}<br>
                        {{ $shippingAddress['city'] ?? 'N/A' }}, {{ $shippingAddress['state'] ?? 'N/A' }}<br>
                        {{ $shippingAddress['country'] ?? 'N/A' }}{{ $shippingAddress['postal_code'] ? ', ' . $shippingAddress['postal_code'] : '' }}
                    </p>
                </div>

                <!-- Estimated Delivery -->
                <div>
                    <h3 class="font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Estimated Delivery
                    </h3>
                    <p class="text-2xl font-bold text-green-600" x-text="estimatedDelivery"></p>
                    <p class="text-sm text-gray-600 mt-1">Standard Delivery (5-7 business days)</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <button @click="downloadReceipt()" class="flex-1 bg-black text-white py-4 rounded-full font-medium hover:bg-gray-800 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Receipt
            </button>
            <a href="/" class="flex-1 border-2 border-gray-300 text-gray-700 py-4 rounded-full font-medium hover:bg-gray-50 transition text-center">
                Continue Shopping
            </a>
        </div>

        <!-- Receipt Content (Hidden for PDF Generation) -->
        <div id="receipt-content" class="bg-white rounded-2xl p-12 hidden">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-2">ShopHub</h1>
                <p class="text-gray-600">Official Receipt</p>
            </div>

            <div class="mb-8 pb-6 border-b-2">
                <div class="flex justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-600">Order Number</p>
                        <p class="font-bold text-lg" x-text="orderNumber"></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Order Date</p>
                        <p class="font-semibold" x-text="orderDate"></p>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div id="qrcode"></div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="font-bold mb-3">Bill To:</h3>
                <p class="text-gray-700">
                    {{ $order->user->name ?? 'Guest User' }}<br>
                    {{ $order->user->email ?? 'N/A' }}<br>
                    {{ $shippingAddress['phone'] ?? 'N/A' }}
                </p>
            </div>

            <div class="mb-8">
                <h3 class="font-bold mb-3">Delivery Address:</h3>
                <p class="text-gray-700">
                    {{ $shippingAddress['address'] ?? 'N/A' }}<br>
                    {{ $shippingAddress['city'] ?? 'N/A' }}, {{ $shippingAddress['state'] ?? 'N/A' }}<br>
                    {{ $shippingAddress['country'] ?? 'N/A' }}{{ $shippingAddress['postal_code'] ? ', ' . $shippingAddress['postal_code'] : '' }}
                </p>
            </div>

            <table class="w-full mb-8">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-3 font-semibold">Item</th>
                        <th class="text-center p-3 font-semibold">Qty</th>
                        <th class="text-right p-3 font-semibold">Price</th>
                        <th class="text-right p-3 font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $item->product_name }}</td>
                        <td class="text-center p-3">{{ $item->quantity }}</td>
                        <td class="text-right p-3">ZMW {{ number_format($item->price, 0) }}</td>
                        <td class="text-right p-3">ZMW {{ number_format($item->total, 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="border-t-2 pt-4">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-semibold">ZMW {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->tax > 0)
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-semibold">ZMW {{ number_format($order->tax, 0) }}</span>
                </div>
                @endif
                @if($order->shipping > 0)
                <div class="flex justify-between mb-4">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-semibold">ZMW {{ number_format($order->shipping, 0) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-xl font-bold border-t-2 pt-4">
                    <span>Total Paid</span>
                    <span>ZMW {{ number_format($order->total, 0) }}</span>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t text-center text-sm text-gray-600">
                <p class="mb-2">Thank you for shopping with ShopHub!</p>
                <p>For support, contact us at support@shophub.com</p>
                <p class="mt-4">www.shophub.com</p>
            </div>
        </div>

        <!-- Tracking Section -->
        <div class="bg-white rounded-2xl p-8 mb-6">
            <h2 class="text-xl font-bold mb-6">Track Your Order</h2>
            <div class="relative">
                <!-- Progress Line -->
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                <div class="absolute left-4 top-0 h-24 w-0.5 bg-green-500"></div>

                <!-- Steps -->
                <div class="space-y-8 relative">
                    <!-- Step 1 - Completed -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 relative z-10">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold">Order Placed</p>
                            <p class="text-sm text-gray-600" x-text="orderDate"></p>
                        </div>
                    </div>

                    <!-- Step 2 - Current -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 relative z-10">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold">Payment Confirmed</p>
                            <p class="text-sm text-gray-600">Your payment has been processed</p>
                        </div>
                    </div>

                    <!-- Step 3 - Pending -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0 relative z-10">
                            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-400">Processing</p>
                            <p class="text-sm text-gray-400">We're preparing your order</p>
                        </div>
                    </div>

                    <!-- Step 4 - Pending -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0 relative z-10">
                            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-400">Shipped</p>
                            <p class="text-sm text-gray-400">Your order is on the way</p>
                        </div>
                    </div>

                    <!-- Step 5 - Pending -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0 relative z-10">
                            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-400">Delivered</p>
                            <p class="text-sm text-gray-400">Order delivered to your address</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Need Help -->
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 text-center">
            <h3 class="font-semibold mb-2">Need Help?</h3>
            <p class="text-sm text-gray-600 mb-4">If you have any questions about your order, feel free to contact us</p>
            <div class="flex justify-center gap-4">
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Contact Support</a>
                <span class="text-gray-300">|</span>
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">View FAQs</a>
            </div>
        </div>
    </div>

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>
