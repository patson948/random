<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">
    @include('components.shop-navigation')

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="/" class="hover:text-black">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-black font-medium">Cart</span>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-4xl font-bold mb-8">YOUR CART</h1>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-6">
                @forelse($cartItems as $item)
                    <div class="flex gap-4 p-6 border rounded-2xl">
                        <!-- Product Image -->
                        <div class="w-28 h-28 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="{{ ($item->product->images && count($item->product->images) > 0) ? $item->product->images[0] : 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&q=80' }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        </div>

                        <!-- Product Details -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <a href="/products/{{ $item->product->slug }}" class="font-semibold text-lg hover:text-gray-600">{{ $item->product->name }}</a>
                                <button onclick="removeItem({{ $item->id }})" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">ZMW {{ number_format($item->product->price, 0) }} each</p>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold">ZMW {{ number_format($item->product->price * $item->quantity, 0) }}</span>
                                
                                <!-- Quantity Controls -->
                                <div class="inline-flex items-center bg-gray-100 rounded-full">
                                    <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-9 h-9 flex items-center justify-center hover:bg-gray-200 rounded-full transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <span class="w-10 text-center font-medium">{{ $item->quantity }}</span>
                                    <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-9 h-9 flex items-center justify-center hover:bg-gray-200 rounded-full transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2">Your cart is empty</h3>
                        <p class="text-gray-600 mb-6">Add some products to get started!</p>
                        <a href="/products" class="inline-block bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                            Continue Shopping
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Order Summary -->
            @if($cartItems->count() > 0)
            <div class="lg:col-span-1">
                <div class="border rounded-2xl p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-semibold text-black">ZMW {{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="border-t pt-4 flex justify-between">
                            <span class="font-semibold text-lg">Total</span>
                            <span class="font-bold text-2xl">ZMW {{ number_format($total, 0) }}</span>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="mb-6">
                        <div class="flex gap-2">
                            <input type="text" placeholder="Add promo code" class="flex-1 px-4 py-3 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black">
                            <button class="bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                                Apply
                            </button>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="block w-full bg-black text-white py-4 rounded-full font-medium hover:bg-gray-800 transition text-center mb-3">
                        Go to Checkout →
                    </a>
                    
                    <button onclick="clearCart()" class="block w-full bg-red-600 text-white py-3 rounded-full font-medium hover:bg-red-700 transition text-center">
                        Clear Cart
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 pt-16 pb-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-12">
                <div class="col-span-2">
                    <h3 class="text-2xl font-bold mb-4">ShopHub</h3>
                    <p class="text-gray-600 mb-6">We have clothes that suits your style and which you're proud to wear.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">COMPANY</h4>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="{{ route('about') }}" class="hover:text-black">About</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-black">Contact</a></li>
                        <li><a href="/search" class="hover:text-black">Shop</a></li>
                        <li><a href="/categories-demo" class="hover:text-black">Categories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">HELP</h4>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="{{ route('faq') }}" class="hover:text-black">FAQ</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-black">Customer Support</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-black">Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-black">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">SHOP</h4>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="/search?category=men" class="hover:text-black">Men's Fashion</a></li>
                        <li><a href="/search?category=women" class="hover:text-black">Women's Fashion</a></li>
                        <li><a href="/search?category=kids" class="hover:text-black">Kids</a></li>
                        <li><a href="/search?sale=1" class="hover:text-black">Sale Items</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t pt-8 text-center text-sm text-gray-600">
                <p>ShopHub © 2000-{{ date('Y') }}, All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <script>
        function removeItem(id) {
            console.log('Removing item:', id);
            if (confirm('Are you sure you want to remove this item?')) {
                fetch(`/cart/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    console.log('Remove response status:', response.status);
                    console.log('Remove response:', response);
                    
                    // Try to get response text first
                    return response.text().then(text => {
                        console.log('Response text:', text);
                        
                        if (!response.ok) {
                            try {
                                const err = JSON.parse(text);
                                throw new Error(err.error || err.message || `Server error: ${response.status}`);
                            } catch (e) {
                                throw new Error(`Server error: ${response.status} - ${text}`);
                            }
                        }
                        
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            throw new Error('Invalid JSON response from server');
                        }
                    });
                })
                .then(data => {
                    console.log('Remove success:', data);
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to remove item');
                    }
                })
                .catch(error => {
                    console.error('Remove error:', error);
                    alert(error.message || 'Failed to remove item. Please try again.');
                });
            }
        }

        function updateQuantity(id, newQuantity) {
            console.log('Updating quantity for item:', id, 'to:', newQuantity);
            
            if (newQuantity <= 0) {
                removeItem(id);
                return;
            }
            
            fetch(`/cart/${id}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            })
            .then(response => {
                console.log('Update response status:', response.status);
                console.log('Update response:', response);
                
                // Try to get response text first
                return response.text().then(text => {
                    console.log('Response text:', text);
                    
                    if (!response.ok) {
                        try {
                            const err = JSON.parse(text);
                            throw new Error(err.error || err.message || `Server error: ${response.status}`);
                        } catch (e) {
                            throw new Error(`Server error: ${response.status} - ${text}`);
                        }
                    }
                    
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Invalid JSON response from server');
                    }
                });
            })
            .then(data => {
                console.log('Update success:', data);
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Failed to update quantity');
                }
            })
            .catch(error => {
                console.error('Update error:', error);
                alert(error.message || 'Failed to update quantity. Please try again.');
            });
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear all items from your cart?')) {
                console.log('Clearing cart');
                fetch('/cart', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                })
                .then(response => {
                    console.log('Clear cart response status:', response.status);
                    console.log('Clear cart response:', response);
                    
                    return response.text().then(text => {
                        console.log('Response text:', text);
                        
                        if (!response.ok) {
                            try {
                                const err = JSON.parse(text);
                                throw new Error(err.error || err.message || `Server error: ${response.status}`);
                            } catch (e) {
                                throw new Error(`Server error: ${response.status} - ${text}`);
                            }
                        }
                        
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            throw new Error('Invalid JSON response from server');
                        }
                    });
                })
                .then(data => {
                    console.log('Clear cart success:', data);
                    location.reload();
                })
                .catch(error => {
                    console.error('Clear cart error:', error);
                    alert(error.message || 'Failed to clear cart. Please try again.');
                });
            }
        }
    </script>

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>
