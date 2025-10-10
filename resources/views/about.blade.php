<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <!-- Authentication Modals -->
    @include('components.auth-modals')
    
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-xs py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <span>Free shipping on orders over ZMW 50,000</span>
            <div class="flex gap-4">
                <span>Help</span>
                <span>Track Order</span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    @include('components.nav')

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-4">About ShopHub</h1>
            <p class="text-xl opacity-90">Your Trusted Marketplace in Zambia</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Our Story -->
        <div class="mb-20">
            <h2 class="text-3xl font-bold mb-6">Our Story</h2>
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Founded in 2024, ShopHub has become Zambia's leading e-commerce platform, connecting thousands of buyers with quality vendors across the country.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        We started with a simple vision: to make online shopping accessible, reliable, and enjoyable for everyone in Zambia. Today, we're proud to serve communities across the nation, offering everything from fashion to electronics.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Our platform empowers local vendors and entrepreneurs to reach a wider audience while providing customers with a seamless shopping experience.
                    </p>
                </div>
                <div class="bg-gray-100 rounded-3xl h-96 flex items-center justify-center">
                    <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Our Mission -->
        <div class="bg-gray-50 rounded-3xl p-12 mb-20">
            <h2 class="text-3xl font-bold mb-6 text-center">Our Mission</h2>
            <p class="text-xl text-gray-700 text-center max-w-3xl mx-auto leading-relaxed">
                To revolutionize e-commerce in Zambia by providing a trusted, user-friendly platform that connects buyers and sellers, promoting economic growth and convenience for all.
            </p>
        </div>

        <!-- Our Values -->
        <div class="mb-20">
            <h2 class="text-3xl font-bold mb-12 text-center">Our Values</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Trust</h3>
                    <p class="text-gray-600">We build trust through transparency, security, and reliable service.</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Innovation</h3>
                    <p class="text-gray-600">We constantly improve our platform to enhance user experience.</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Community</h3>
                    <p class="text-gray-600">We support local businesses and empower our community.</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-white mb-20">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">10,000+</div>
                    <div class="text-sm opacity-90">Happy Customers</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">500+</div>
                    <div class="text-sm opacity-90">Trusted Vendors</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">50,000+</div>
                    <div class="text-sm opacity-90">Products Listed</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-sm opacity-90">Customer Support</div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Start Shopping?</h2>
            <p class="text-gray-600 mb-8">Explore thousands of products from trusted vendors across Zambia</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('search') }}" class="bg-black text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                    Browse Products
                </a>
                <a href="/contact" class="border-2 border-gray-300 px-8 py-3 rounded-full font-medium hover:bg-gray-50 transition">
                    Contact Us
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>

