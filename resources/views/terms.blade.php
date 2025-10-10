<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - ShopHub</title>
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

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-4xl font-bold mb-4">Terms & Conditions</h1>
        <p class="text-gray-600 mb-8">Last updated: {{ date('F d, Y') }}</p>

        <div class="prose prose-lg max-w-none space-y-8">
            <section>
                <h2 class="text-2xl font-bold mb-4">1. Introduction</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Welcome to ShopHub. These Terms and Conditions ("Terms") govern your use of our website and services. By accessing or using ShopHub, you agree to be bound by these Terms.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">2. Account Registration</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    To use certain features of ShopHub, you must register for an account. You agree to:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Provide accurate and complete information</li>
                    <li>Maintain the security of your account credentials</li>
                    <li>Notify us immediately of any unauthorized use</li>
                    <li>Be responsible for all activities under your account</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">3. Products and Services</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    ShopHub acts as a marketplace connecting buyers and vendors. We strive to ensure accuracy in product descriptions, but we do not guarantee that all information is complete or error-free.
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Prices are subject to change without notice</li>
                    <li>Product availability is not guaranteed</li>
                    <li>We reserve the right to limit quantities</li>
                    <li>Product images may differ from actual items</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">4. Orders and Payment</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    When you place an order through ShopHub:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>You agree to provide valid payment information</li>
                    <li>Payment is processed securely through approved gateways</li>
                    <li>Orders are subject to availability and confirmation</li>
                    <li>We reserve the right to refuse or cancel any order</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">5. Shipping and Delivery</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Delivery times are estimates and may vary. ShopHub is not responsible for delays caused by vendors or third-party delivery services.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">6. Returns and Refunds</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Our 30-day return policy applies to eligible products. To initiate a return:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Products must be unused and in original packaging</li>
                    <li>Return shipping costs may apply</li>
                    <li>Refunds are processed within 7-14 business days</li>
                    <li>Some products may not be eligible for return</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">7. User Conduct</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    You agree not to:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Use the platform for illegal purposes</li>
                    <li>Violate any applicable laws or regulations</li>
                    <li>Interfere with the proper functioning of the website</li>
                    <li>Attempt to gain unauthorized access to our systems</li>
                    <li>Post false, misleading, or fraudulent content</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">8. Intellectual Property</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    All content on ShopHub, including text, graphics, logos, and software, is protected by intellectual property laws and belongs to ShopHub or its licensors.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">9. Limitation of Liability</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    ShopHub shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of the platform or inability to use the services.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">10. Changes to Terms</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We reserve the right to modify these Terms at any time. Continued use of ShopHub after changes constitutes acceptance of the revised Terms.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">11. Contact Us</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    If you have questions about these Terms, please contact us at:
                </p>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <p class="text-gray-700">Email: legal@shophub.zm</p>
                    <p class="text-gray-700">Phone: +260 XXX XXX XXX</p>
                    <p class="text-gray-700">Address: Cairo Road, Lusaka, Zambia</p>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    <!-- WhatsApp Floating Button -->
    @include('components.whatsapp-float')
</body>
</html>

