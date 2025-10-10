<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - ShopHub</title>
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
            <h1 class="text-5xl font-bold mb-4">Frequently Asked Questions</h1>
            <p class="text-xl opacity-90">Find answers to common questions about ShopHub</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="space-y-4" x-data="{ activeAccordion: null }">
            <!-- General Questions -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold mb-6">General Questions</h2>
                
                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">What is ShopHub?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 1 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse class="p-6 pt-0 text-gray-700">
                        ShopHub is Zambia's leading e-commerce marketplace connecting buyers with trusted vendors across the country. We offer a wide range of products from fashion to electronics, all in one convenient platform.
                    </div>
                </div>

                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">How do I create an account?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 2 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse class="p-6 pt-0 text-gray-700">
                        Click on the "Sign In" button in the top right corner, then select "Register". Fill in your details including name, email, and password. You'll receive a verification email to activate your account.
                    </div>
                </div>

                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">Is shopping on ShopHub safe?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 3 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse class="p-6 pt-0 text-gray-700">
                        Yes! We use industry-standard SSL encryption to protect your data. All payments are processed through secure payment gateways, and we never store your complete payment information.
                    </div>
                </div>
            </div>

            <!-- Orders & Payment -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold mb-6">Orders & Payment</h2>
                
                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 4 ? null : 4" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">What payment methods do you accept?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 4 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 4" x-collapse class="p-6 pt-0 text-gray-700">
                        We accept Mobile Money, Credit/Debit Cards (Visa, Mastercard), and Bank Transfers. Payment on delivery is available for select areas.
                    </div>
                </div>

                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 5 ? null : 5" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">How do I track my order?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 5 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 5" x-collapse class="p-6 pt-0 text-gray-700">
                        After placing an order, you'll receive a tracking number via email and SMS. You can track your order from your account dashboard or by entering the tracking number on our Track Order page.
                    </div>
                </div>

                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 6 ? null : 6" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">Can I cancel my order?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 6 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 6" x-collapse class="p-6 pt-0 text-gray-700">
                        You can cancel your order before it ships. Go to your order history, select the order, and click "Cancel Order". If the order has already shipped, you can refuse delivery or initiate a return once received.
                    </div>
                </div>
            </div>

            <!-- Shipping & Delivery -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold mb-6">Shipping & Delivery</h2>
                
                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 7 ? null : 7" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">What are the shipping charges?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 7 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 7" x-collapse class="p-6 pt-0 text-gray-700">
                        We offer FREE shipping on orders over ZMW 50,000. For orders below this amount, standard shipping fees apply based on your location and the size of your package.
                    </div>
                </div>

                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 8 ? null : 8" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">How long does delivery take?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 8 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 8" x-collapse class="p-6 pt-0 text-gray-700">
                        Delivery times vary by location: Lusaka (2-3 business days), Copperbelt (3-5 business days), Other areas (5-7 business days). Express delivery is available for select areas.
                    </div>
                </div>
            </div>

            <!-- Returns & Refunds -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold mb-6">Returns & Refunds</h2>
                
                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 9 ? null : 9" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">What is your return policy?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 9 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 9" x-collapse class="p-6 pt-0 text-gray-700">
                        We offer a 30-day return policy. Products must be unused, in original packaging, and with all tags attached. Return shipping costs may apply unless the item is defective or incorrect.
                    </div>
                </div>

                <div class="border-2 border-gray-100 rounded-2xl overflow-hidden mb-4">
                    <button @click="activeAccordion = activeAccordion === 10 ? null : 10" class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-lg">How long do refunds take?</span>
                        <svg :class="{ 'rotate-180': activeAccordion === 10 }" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 10" x-collapse class="p-6 pt-0 text-gray-700">
                        Once we receive and inspect your returned item, we'll process your refund within 3-5 business days. The refund will appear in your original payment method within 7-14 business days.
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-center text-white mt-16">
            <h2 class="text-3xl font-bold mb-4">Still Have Questions?</h2>
            <p class="text-lg mb-6 opacity-90">Our customer support team is here to help</p>
            <a href="/contact" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-full font-medium hover:bg-gray-100 transition">
                Contact Us
            </a>
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>

