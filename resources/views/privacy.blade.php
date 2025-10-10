<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - ShopHub</title>
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
        <h1 class="text-4xl font-bold mb-4">Privacy Policy</h1>
        <p class="text-gray-600 mb-8">Last updated: {{ date('F d, Y') }}</p>

        <div class="prose prose-lg max-w-none space-y-8">
            <section>
                <h2 class="text-2xl font-bold mb-4">1. Introduction</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    ShopHub ("we," "us," or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our platform.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">2. Information We Collect</h2>
                <h3 class="text-xl font-semibold mb-3">Personal Information</h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We may collect personal information that you provide directly, including:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700 mb-6">
                    <li>Name, email address, and phone number</li>
                    <li>Shipping and billing addresses</li>
                    <li>Payment information</li>
                    <li>Account credentials</li>
                    <li>Purchase history and preferences</li>
                </ul>

                <h3 class="text-xl font-semibold mb-3">Automatically Collected Information</h3>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>IP address and browser information</li>
                    <li>Device information and operating system</li>
                    <li>Usage data and analytics</li>
                    <li>Cookies and similar tracking technologies</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">3. How We Use Your Information</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We use your information to:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Process and fulfill your orders</li>
                    <li>Communicate with you about your purchases</li>
                    <li>Provide customer support</li>
                    <li>Improve our services and user experience</li>
                    <li>Send promotional communications (with your consent)</li>
                    <li>Detect and prevent fraud</li>
                    <li>Comply with legal obligations</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">4. Information Sharing</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We may share your information with:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li><strong>Vendors:</strong> To fulfill your orders</li>
                    <li><strong>Service Providers:</strong> For payment processing, delivery, and analytics</li>
                    <li><strong>Legal Authorities:</strong> When required by law</li>
                    <li><strong>Business Transfers:</strong> In case of merger or acquisition</li>
                </ul>
                <p class="text-gray-700 leading-relaxed mt-4">
                    We do not sell your personal information to third parties.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">5. Data Security</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We implement appropriate technical and organizational measures to protect your personal information, including:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Secure SSL encryption for data transmission</li>
                    <li>Regular security audits and updates</li>
                    <li>Access controls and authentication</li>
                    <li>Secure payment processing through trusted gateways</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">6. Your Rights</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    You have the right to:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Access your personal information</li>
                    <li>Correct inaccurate data</li>
                    <li>Request deletion of your data</li>
                    <li>Opt-out of marketing communications</li>
                    <li>Restrict or object to certain processing</li>
                    <li>Data portability</li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">7. Cookies</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We use cookies and similar technologies to enhance your experience. You can control cookies through your browser settings, but some features may not function properly if cookies are disabled.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">8. Children's Privacy</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    ShopHub is not intended for children under 13. We do not knowingly collect personal information from children. If you believe we have collected information from a child, please contact us.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">9. Changes to Privacy Policy</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We may update this Privacy Policy periodically. We will notify you of significant changes through email or prominent notice on our website.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold mb-4">10. Contact Us</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    For questions or concerns about this Privacy Policy or our data practices:
                </p>
                <div class="bg-gray-50 rounded-2xl p-6">
                    <p class="text-gray-700">Email: privacy@shophub.zm</p>
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

