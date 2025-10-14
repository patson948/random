<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ShopHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true, showUserMenu: false }">
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out lg:translate-x-0">
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 border-b">
            <a href="/admin/dashboard" class="text-2xl font-bold">ShopHub</a>
            <button @click="sidebarOpen = false" class="lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-1">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 text-sm font-medium bg-gray-100 text-black rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="/admin/orders" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Orders
            </a>

            <a href="/admin/products" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Products
            </a>

            <a href="/admin/vendors" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Vendors
            </a>

            <a href="/admin/categories" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Categories
            </a>

            <a href="/admin/home-sections" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                </svg>
                Home Sections
            </a>

            <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Customers
            </a>

            <a href="/admin/reports" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Reports
            </a>

            <a href="/admin/settings" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>
        </nav>

        <!-- Bottom Section -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t">
            <a href="/" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                View Store
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-64">
        <!-- Top Bar -->
        <header class="sticky top-0 z-40 bg-white border-b">
            <div class="flex items-center justify-between h-16 px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="flex items-center gap-4 ml-auto">
                    <!-- Search -->
                    <div class="hidden md:block relative">
                        <input type="text" placeholder="Search..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-black">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <!-- Notifications -->
                    <button class="relative">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </button>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gray-900 text-white rounded-full flex items-center justify-center font-semibold">
                                A
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium">Admin User</p>
                                <p class="text-xs text-gray-500">admin@shophub.com</p>
                            </div>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border py-2">
                            <a href="/admin/profile" class="block px-4 py-2 text-sm hover:bg-gray-50">Profile Settings</a>
                            <a href="/admin/security" class="block px-4 py-2 text-sm hover:bg-gray-50">Security</a>
                            <hr class="my-2">
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Sign Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-6">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-2">Welcome back, Admin! 👋</h1>
                <p class="text-gray-600">Here's what's happening with your store today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600">+12.5%</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">₦2.4M</h3>
                    <p class="text-sm text-gray-600">Total Revenue</p>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600">+8.2%</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">1,428</h3>
                    <p class="text-sm text-gray-600">Total Orders</p>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600">+24</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">348</h3>
                    <p class="text-sm text-gray-600">Total Products</p>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600">+156</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-1">8,549</h3>
                    <p class="text-sm text-gray-600">Total Customers</p>
                </div>
            </div>

            <!-- Charts & Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Recent Orders -->
                <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Recent Orders</h2>
                        <a href="/admin/orders" class="text-sm font-medium text-black hover:underline">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Order ID</th>
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Customer</th>
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Amount</th>
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-medium">#ORD-2024-001</td>
                                    <td class="py-3 px-4 text-sm">John Doe</td>
                                    <td class="py-3 px-4 text-sm font-semibold">ZMW 45,000</td>
                                    <td class="py-3 px-4"><span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Delivered</span></td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-medium">#ORD-2024-002</td>
                                    <td class="py-3 px-4 text-sm">Jane Smith</td>
                                    <td class="py-3 px-4 text-sm font-semibold">ZMW 28,500</td>
                                    <td class="py-3 px-4"><span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Shipped</span></td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-medium">#ORD-2024-003</td>
                                    <td class="py-3 px-4 text-sm">Mike Johnson</td>
                                    <td class="py-3 px-4 text-sm font-semibold">ZMW 67,200</td>
                                    <td class="py-3 px-4"><span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Processing</span></td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-medium">#ORD-2024-004</td>
                                    <td class="py-3 px-4 text-sm">Sarah Williams</td>
                                    <td class="py-3 px-4 text-sm font-semibold">ZMW 15,800</td>
                                    <td class="py-3 px-4"><span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">Pending</span></td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-medium">#ORD-2024-005</td>
                                    <td class="py-3 px-4 text-sm">David Brown</td>
                                    <td class="py-3 px-4 text-sm font-semibold">ZMW 92,400</td>
                                    <td class="py-3 px-4"><span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Delivered</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top Products -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Top Products</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Wireless Earbuds</p>
                                <p class="text-xs text-gray-500">234 sold</p>
                            </div>
                            <p class="text-sm font-bold">₦35,000</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Smart Watch Pro</p>
                                <p class="text-xs text-gray-500">189 sold</p>
                            </div>
                            <p class="text-sm font-bold">₦75,000</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Designer Handbag</p>
                                <p class="text-xs text-gray-500">156 sold</p>
                            </div>
                            <p class="text-sm font-bold">₦48,000</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Running Shoes Pro</p>
                                <p class="text-xs text-gray-500">142 sold</p>
                            </div>
                            <p class="text-sm font-bold">₦45,000</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Cookware Set</p>
                                <p class="text-xs text-gray-500">128 sold</p>
                            </div>
                            <p class="text-sm font-bold">₦48,000</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vendors & Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Active Vendors -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Active Vendors</h2>
                        <a href="/admin/vendors" class="text-sm font-medium text-black hover:underline">View All</a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center font-semibold text-purple-600">S</div>
                                <div>
                                    <p class="text-sm font-medium">StyleHub Fashion</p>
                                    <p class="text-xs text-gray-500">156 products</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center font-semibold text-blue-600">T</div>
                                <div>
                                    <p class="text-sm font-medium">TechVault</p>
                                    <p class="text-xs text-gray-500">89 products</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center font-semibold text-green-600">H</div>
                                <div>
                                    <p class="text-sm font-medium">HomeComfort</p>
                                    <p class="text-xs text-gray-500">67 products</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center font-semibold text-orange-600">A</div>
                                <div>
                                    <p class="text-sm font-medium">ActiveLife Sports</p>
                                    <p class="text-xs text-gray-500">52 products</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-xl font-bold mb-6">Recent Activity</h2>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">New order placed</p>
                                <p class="text-xs text-gray-500">Order #ORD-2024-005 by David Brown</p>
                                <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Product approved</p>
                                <p class="text-xs text-gray-500">Wireless Mouse by TechVault</p>
                                <p class="text-xs text-gray-400 mt-1">15 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">New vendor registered</p>
                                <p class="text-xs text-gray-500">FashionForward Store</p>
                                <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Order delivered</p>
                                <p class="text-xs text-gray-500">Order #ORD-2024-001 completed</p>
                                <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">Low stock alert</p>
                                <p class="text-xs text-gray-500">Smart Watch Pro (5 units left)</p>
                                <p class="text-xs text-gray-400 mt-1">5 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
