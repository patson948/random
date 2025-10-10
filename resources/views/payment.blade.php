<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .modal-backdrop { background-color: rgba(0, 0, 0, 0.5); }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.shop-navigation')
    
    <!-- Payment Progress -->
    <div class="bg-white border-b py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                <span class="flex items-center gap-2 text-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Cart
                </span>
                <span class="text-gray-300">→</span>
                <span class="flex items-center gap-2 text-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    Address
                </span>
                <span class="text-gray-300">→</span>
                <span class="flex items-center gap-2 font-medium text-black">
                    <div class="w-5 h-5 bg-black rounded-full text-white flex items-center justify-center text-xs">3</div>
                    Payment
                </span>
            </div>
        </div>
    </div>

    <!-- Payment Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="paymentData()">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Payment Form -->
            <div class="lg:col-span-2 space-y-8">
                <form method="POST" action="{{ route('payment.process') }}">
                    @csrf
                    
                    <!-- Payment Method -->
                    <div class="bg-white rounded-2xl p-8">
                        <h2 class="text-2xl font-bold mb-6">Payment Method</h2>
                        <div class="space-y-4">
                            <!-- Mobile Money -->
                            <div @click="showMobileMoneyModal = true" class="flex items-start gap-4 p-4 border-2 border-black rounded-xl cursor-pointer hover:border-gray-800">
                                <div class="mt-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-semibold">Mobile Money</span>
                                        <div class="flex gap-2">
                                            <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-medium rounded">Airtel</span>
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 text-xs font-medium rounded">MTN</span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">Pay instantly with Airtel Money or MTN Mobile Money</p>
                                </div>
                            </div>

                            <!-- Cards - Coming Soon -->
                            <div class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl opacity-60 cursor-not-allowed">
                                <div class="mt-1">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-semibold text-gray-500">Credit/Debit Card</span>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-600 text-xs font-medium rounded">Coming Soon</span>
                                    </div>
                                    <p class="text-sm text-gray-400">Pay securely with your card</p>
                                </div>
                            </div>

                            <!-- Bank Transfer - Coming Soon -->
                            <div class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl opacity-60 cursor-not-allowed">
                                <div class="mt-1">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-semibold text-gray-500">Bank Transfer</span>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-600 text-xs font-medium rounded">Coming Soon</span>
                                    </div>
                                    <p class="text-sm text-gray-400">Transfer directly to our account</p>
                                </div>
                            </div>

                            <!-- Cash on Delivery - Coming Soon -->
                            <div class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl opacity-60 cursor-not-allowed">
                                <div class="mt-1">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-semibold text-gray-500">Cash on Delivery</span>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-600 text-xs font-medium rounded">Coming Soon</span>
                                    </div>
                                    <p class="text-sm text-gray-400">Pay when your order arrives</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address Review -->
                    <div class="bg-white rounded-2xl p-8">
                        <h2 class="text-2xl font-bold mb-6">Delivery Address</h2>
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="space-y-2">
                                <p class="font-semibold">{{ $address['shipping_name'] }}</p>
                                <p class="text-gray-600">{{ $address['shipping_address'] }}</p>
                                <p class="text-gray-600">{{ $address['shipping_city'] }}, {{ $address['shipping_state'] }} {{ $address['shipping_postal_code'] }}</p>
                                <p class="text-gray-600">{{ $address['shipping_country'] }}</p>
                                <p class="text-gray-600">{{ $address['shipping_phone'] }}</p>
                            </div>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="text-blue-600 text-sm hover:underline mt-4 inline-block">
                            ← Change address
                        </a>
                    </div>

                    <!-- Pay Now Button -->
                    <div class="bg-white rounded-2xl p-8">
                        <button @click="showMobileMoneyModal = true" 
                                type="button"
                                class="w-full bg-black text-white py-4 rounded-full font-semibold hover:bg-gray-800 transition text-lg mb-4">
                            Pay Now - ZMW {{ number_format($total, 0) }} →
                        </button>
                        
                        <div class="flex gap-4">
                            <a href="{{ route('checkout.index') }}" class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-xl font-medium hover:bg-gray-300 transition text-center">
                                ← Back to Address
                            </a>
                            <a href="{{ route('cart.index') }}" class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-xl font-medium hover:bg-gray-300 transition text-center">
                                Back to Cart
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-8 sticky top-4">
                    <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                    
                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex gap-3">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $item->product->main_image ?? 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=200&q=80' }}" 
                                     alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-sm truncate">{{ $item->product->name }}</h4>
                                <p class="text-xs text-gray-600">{{ $item->product->vendor->store_name ?? 'Vendor' }}</p>
                                <p class="text-sm font-semibold mt-1">ZMW {{ number_format($item->product->price, 0) }}</p>
                            </div>
                            <span class="text-sm text-gray-600">×{{ $item->quantity }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-b py-4 space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-semibold text-black">ZMW {{ number_format($subtotal, 0) }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between mb-8">
                        <span class="font-semibold text-lg">Total</span>
                        <span class="font-bold text-2xl">ZMW {{ number_format($total, 0) }}</span>
                    </div>

                    <div class="text-center text-sm text-gray-600">
                        Review your order before placing
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Money Payment Modal -->
        <div x-show="showMobileMoneyModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            <!-- Backdrop -->
            <div class="modal-backdrop fixed inset-0" @click="showMobileMoneyModal = false"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative z-10" @click.stop>
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b">
                        <h3 class="text-xl font-bold">Mobile Money Payment</h3>
                        <button @click="showMobileMoneyModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form method="POST" action="{{ route('lenco.initiate') }}" class="p-6" @submit="processPayment($event)">
                        @csrf
                        
                        <!-- Hidden Fields -->
                        <input type="hidden" name="currency" value="ZMW">
                        <input type="hidden" name="country" value="ZM">
                        <input type="hidden" name="amount" value="{{ $total }}">
                        <input type="hidden" name="bearer" value="customer">

                        <!-- Network Operator -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-3">Select Network Operator</label>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="selectedOperator === 'mtn' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" name="operator" value="mtn" x-model="selectedOperator" required class="text-yellow-500">
                                    <div class="flex-1">
                                        <div class="font-semibold">MTN Mobile Money</div>
                                        <div class="text-xs text-gray-500">Pay with your MTN account</div>
                                    </div>
                                    <div class="w-12 h-12 bg-yellow-400 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">MTN</span>
                                    </div>
                                </label>

                                <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition"
                                       :class="selectedOperator === 'airtel' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" name="operator" value="airtel" x-model="selectedOperator" required class="text-red-500">
                                    <div class="flex-1">
                                        <div class="font-semibold">Airtel Money</div>
                                        <div class="text-xs text-gray-500">Pay with your Airtel account</div>
                                    </div>
                                    <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">Airtel</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-semibold mb-2">Phone Number</label>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone" 
                                   x-model="phoneNumber"
                                   placeholder="260971234567 or 0971234567" 
                                   required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <p class="text-xs text-gray-500 mt-2">Enter your mobile money number</p>
                        </div>

                        <!-- Amount Display -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Amount to Pay</span>
                                <span class="text-xl font-bold">ZMW {{ number_format($total, 0) }}</span>
                            </div>
                        </div>

                        <!-- Info Message -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-xl flex gap-3">
                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-blue-700">
                                <p class="font-semibold mb-1">How it works:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    <li>Enter your mobile money number</li>
                                    <li>You'll receive a prompt on your phone</li>
                                    <li>Enter your PIN to complete payment</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                :disabled="isProcessing"
                                :class="isProcessing ? 'bg-gray-400 cursor-not-allowed' : 'bg-black hover:bg-gray-800'"
                                class="w-full text-white py-4 rounded-xl font-semibold transition">
                            <span x-show="!isProcessing">Proceed to Pay ZMW {{ number_format($total, 0) }}</span>
                            <span x-show="isProcessing" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing Payment...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function paymentData() {
            return {
                showMobileMoneyModal: false,
                selectedOperator: 'mtn',
                phoneNumber: '',
                isProcessing: false,
                currentReference: null,
                timeoutId: null,

                processPayment(event) {
                    event.preventDefault();
                    
                    if (this.isProcessing) return;
                    
                    this.isProcessing = true;
                    
                    // Get form data
                    const form = event.target;
                    const formData = new FormData(form);
                    
                    // Submit the form
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (response.redirected) {
                            // If redirected, follow the redirect
                            window.location.href = response.url;
                        } else {
                            return response.json();
                        }
                    })
                    .then(data => {
                        if (data && data.reference) {
                            this.currentReference = data.reference;
                            this.startPaymentMonitoring();
                        }
                    })
                    .catch(error => {
                        console.error('Payment initiation error:', error);
                        this.isProcessing = false;
                        alert('Failed to initiate payment. Please try again.');
                    });
                },

                startPaymentMonitoring() {
                    // Set timeout for 25 seconds
                    this.timeoutId = setTimeout(() => {
                        this.handleTimeout();
                    }, 25000);

                    // Start polling for payment status
                    this.pollPaymentStatus();
                },

                pollPaymentStatus() {
                    if (!this.currentReference) return;

                    fetch(`/lenco/status/${this.currentReference}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.redirected) {
                            // Payment successful, redirect to order success
                            clearTimeout(this.timeoutId);
                            window.location.href = response.url;
                        } else {
                            return response.text();
                        }
                    })
                    .then(html => {
                        if (html) {
                            // Check if payment is still pending
                            if (html.includes('pending') || html.includes('otp-required')) {
                                // Continue polling
                                setTimeout(() => this.pollPaymentStatus(), 2000);
                            } else if (html.includes('successful')) {
                                // Payment successful
                                clearTimeout(this.timeoutId);
                                window.location.reload();
                            } else if (html.includes('failed') || html.includes('cancelled')) {
                                // Payment failed
                                clearTimeout(this.timeoutId);
                                this.isProcessing = false;
                                alert('Payment failed. Please try again.');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Payment status check error:', error);
                        // Continue polling on error
                        setTimeout(() => this.pollPaymentStatus(), 2000);
                    });
                },

                handleTimeout() {
                    if (!this.currentReference) return;

                    // Call timeout handler
                    fetch('/lenco/timeout', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            reference: this.currentReference
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.isProcessing = false;
                        if (data.success) {
                            alert('Payment is taking longer than expected. Your order has been created with pending payment status. You can complete the payment later.');
                            window.location.href = `/order-success/${data.order_id}`;
                        } else {
                            alert('Payment timeout. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Timeout handler error:', error);
                        this.isProcessing = false;
                        alert('Payment timeout. Please try again.');
                    });
                }
            }
        }
    </script>

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>