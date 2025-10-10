<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <span>Free shipping on orders over ₦50,000</span>
            <div class="flex gap-4">
                <span>Help</span>
                <span class="font-semibold">Track Order</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white border-b sticky top-0 z-50" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <a href="/" class="text-2xl font-bold">ShopHub</a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/products?category=men" class="text-sm font-medium hover:text-gray-600">Men</a>
                    <a href="/products?category=women" class="text-sm font-medium hover:text-gray-600">Women</a>
                    <a href="/products?category=kids" class="text-sm font-medium hover:text-gray-600">Kids</a>
                    <a href="/products?category=sports" class="text-sm font-medium hover:text-gray-600">Sports</a>
                    <a href="/products" class="text-sm font-medium hover:text-gray-600">Brands</a>
                    <a href="/products?featured=1" class="text-sm font-medium text-red-600 hover:text-red-700">Sale</a>
                </div>

                <div class="flex items-center space-x-6">
                    <a href="/cart" class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>

                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium">U</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <a href="/" class="hover:text-black">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-black font-medium">Track Order</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{
        showTracking: false,
        orderNumber: '',
        email: '',
        trackingData: {
            orderNumber: 'ORD-A7B9C3D1E',
            orderDate: 'October 5, 2025',
            status: 'In Transit',
            estimatedDelivery: 'October 10, 2025',
            carrier: 'DHL Express',
            trackingNumber: 'DHL1234567890',
            currentLocation: 'Lagos Distribution Center',
            items: [
                { name: 'Gradient Graphic T-shirt', qty: 1, image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=200&q=80' },
                { name: 'Checkered Shirt', qty: 1, image: 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=200&q=80' }
            ],
            timeline: [
                { status: 'Order Placed', date: 'Oct 5, 2025 10:30 AM', completed: true, description: 'Your order has been received' },
                { status: 'Payment Confirmed', date: 'Oct 5, 2025 10:31 AM', completed: true, description: 'Payment successfully processed' },
                { status: 'Processing', date: 'Oct 5, 2025 2:15 PM', completed: true, description: 'Order is being prepared' },
                { status: 'Shipped', date: 'Oct 6, 2025 9:00 AM', completed: true, description: 'Package dispatched from warehouse' },
                { status: 'In Transit', date: 'Oct 7, 2025 3:45 PM', completed: true, description: 'Currently at Lagos Distribution Center', current: true },
                { status: 'Out for Delivery', date: 'Pending', completed: false, description: 'Package will be delivered soon' },
                { status: 'Delivered', date: 'Pending', completed: false, description: 'Package delivered to recipient' }
            ],
            shippingAddress: {
                name: 'John Doe',
                address: '123 Main Street, Apartment 4B',
                city: 'Victoria Island, Lagos',
                country: 'Nigeria, 100001',
                phone: '+234 800 000 0000'
            }
        },
        trackOrder() {
            if (this.orderNumber && this.email) {
                this.showTracking = true;
            }
        }
    }">
        <!-- Tracking Form -->
        <div x-show="!showTracking" class="bg-white rounded-3xl shadow-sm p-8 md:p-12">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold mb-3">Track Your Order</h1>
                <p class="text-gray-600">Enter your order details to track your package</p>
            </div>

            <form @submit.prevent="trackOrder()" class="space-y-6 max-w-md mx-auto">
                <div>
                    <label class="block text-sm font-semibold mb-2">Order Number</label>
                    <input 
                        type="text" 
                        x-model="orderNumber"
                        placeholder="e.g., ORD-A7B9C3D1E" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-2">Found in your order confirmation email</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Email Address</label>
                    <input 
                        type="email" 
                        x-model="email"
                        placeholder="Enter your email" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black"
                        required
                    >
                    <p class="text-sm text-gray-500 mt-2">Email used when placing the order</p>
                </div>

                <button type="submit" class="w-full bg-black text-white py-4 rounded-full font-semibold hover:bg-gray-800 transition">
                    Track Order
                </button>
            </form>

            <!-- Quick Tips -->
            <div class="mt-12 pt-8 border-t">
                <h3 class="font-semibold mb-4 text-center">Tracking Tips</h3>
                <div class="grid md:grid-cols-3 gap-6 text-center">
                    <div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="font-medium mb-1">Check Your Email</h4>
                        <p class="text-sm text-gray-600">Your order number is in the confirmation email</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-medium mb-1">Real-time Updates</h4>
                        <p class="text-sm text-gray-600">Get live tracking information</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-medium mb-1">24/7 Support</h4>
                        <p class="text-sm text-gray-600">Need help? We're here for you</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Results -->
        <div x-show="showTracking" x-cloak class="space-y-6">
            <!-- Back Button -->
            <button @click="showTracking = false" class="flex items-center gap-2 text-gray-600 hover:text-black transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Track Another Order
            </button>

            <!-- Status Overview -->
            <div class="bg-white rounded-3xl shadow-sm p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h2 class="text-2xl font-bold" x-text="trackingData.orderNumber"></h2>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full" x-text="trackingData.status"></span>
                        </div>
                        <p class="text-gray-600">Placed on <span x-text="trackingData.orderDate"></span></p>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-sm text-gray-600 mb-1">Estimated Delivery</p>
                        <p class="text-2xl font-bold text-green-600" x-text="trackingData.estimatedDelivery"></p>
                    </div>
                </div>

                <!-- Carrier Info -->
                <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold mb-1">Shipping Carrier</h3>
                            <p class="text-gray-700 mb-2" x-text="trackingData.carrier"></p>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">Tracking #:</span>
                                    <code class="text-sm font-mono bg-white px-2 py-1 rounded" x-text="trackingData.trackingNumber"></code>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600">Current Location:</span>
                                    <span class="text-sm font-medium" x-text="trackingData.currentLocation"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-8">
                    <h3 class="font-semibold mb-4">Order Items</h3>
                    <div class="space-y-3">
                        <template x-for="item in trackingData.items" :key="item.name">
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                                <img :src="item.image" :alt="item.name" class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium" x-text="item.name"></h4>
                                    <p class="text-sm text-gray-600">Quantity: <span x-text="item.qty"></span></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Tracking Timeline -->
                <div>
                    <h3 class="font-semibold mb-6">Tracking History</h3>
                    <div class="relative">
                        <!-- Progress Line -->
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                        
                        <!-- Dynamic Progress Line -->
                        <div class="absolute left-4 top-0 w-0.5 bg-green-500" style="height: 65%"></div>

                        <!-- Timeline Items -->
                        <div class="space-y-8 relative">
                            <template x-for="(step, index) in trackingData.timeline" :key="index">
                                <div class="flex gap-4">
                                    <div 
                                        class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 relative z-10 transition"
                                        :class="step.completed ? 'bg-green-500' : 'bg-gray-200'"
                                    >
                                        <svg x-show="step.completed" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                        </svg>
                                        <div x-show="!step.completed" class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                    </div>
                                    <div class="flex-1 pb-8">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1">
                                            <h4 
                                                class="font-semibold"
                                                :class="step.current ? 'text-green-600' : step.completed ? 'text-black' : 'text-gray-400'"
                                                x-text="step.status"
                                            ></h4>
                                            <span 
                                                class="text-sm"
                                                :class="step.completed ? 'text-gray-600' : 'text-gray-400'"
                                                x-text="step.date"
                                            ></span>
                                        </div>
                                        <p 
                                            class="text-sm"
                                            :class="step.completed ? 'text-gray-600' : 'text-gray-400'"
                                            x-text="step.description"
                                        ></p>
                                        <span x-show="step.current" class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                            Current Status
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Details -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Delivery Address
                    </h3>
                    <div class="text-gray-700 leading-relaxed">
                        <p class="font-medium" x-text="trackingData.shippingAddress.name"></p>
                        <p x-text="trackingData.shippingAddress.address"></p>
                        <p x-text="trackingData.shippingAddress.city"></p>
                        <p x-text="trackingData.shippingAddress.country"></p>
                        <p class="mt-2" x-text="trackingData.shippingAddress.phone"></p>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-sm p-6 text-white">
                    <h3 class="font-semibold mb-2">Need Help?</h3>
                    <p class="text-sm opacity-90 mb-6">Our support team is available 24/7 to assist you</p>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center gap-3 bg-white/20 hover:bg-white/30 transition rounded-xl p-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div>
                                <p class="text-xs opacity-75">Call Us</p>
                                <p class="font-medium">+234 800 000 0000</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-center gap-3 bg-white/20 hover:bg-white/30 transition rounded-xl p-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <div>
                                <p class="text-xs opacity-75">Live Chat</p>
                                <p class="font-medium">Start a conversation</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="/order-success-demo" class="flex-1 bg-black text-white py-4 rounded-full font-medium hover:bg-gray-800 transition text-center">
                    View Full Order Details
                </a>
                <button class="flex-1 border-2 border-gray-300 text-gray-700 py-4 rounded-full font-medium hover:bg-gray-50 transition">
                    Contact Support
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 pt-16 pb-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-12">
                <div class="col-span-2">
                    <h3 class="text-2xl font-bold mb-4">ShopHub</h3>
                    <p class="text-gray-600 mb-6">We have clothes that suits your style.</p>
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

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
