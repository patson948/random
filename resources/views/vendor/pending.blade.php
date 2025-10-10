<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12 text-center">
                <!-- Icon -->
                <div class="mb-8">
                    <div class="w-24 h-24 bg-yellow-50 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Content -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Vendor Account Pending Approval</h1>
                <p class="text-lg text-gray-600 mb-8">Thank you for registering as a vendor! Your account is currently being reviewed by our admin team.</p>
                
                <!-- Info Box -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-xl p-6 mb-8 text-left">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-yellow-800 mb-1">What's Next?</h3>
                            <p class="text-sm text-yellow-700">You will receive a notification once your account has been approved. This usually takes 1-2 business days.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 bg-black text-white px-8 py-4 rounded-full hover:bg-gray-800 transition font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
