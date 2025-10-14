<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4 border-b border-gray-700">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                @auth
                <div class="mt-3 flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div class="text-xs">
                        <div class="font-medium">{{ auth()->user()->name }}</div>
                        <div class="text-gray-400">Administrator</div>
                    </div>
                </div>
                @endauth
            </div>
            <nav class="mt-2 flex-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.vendors.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.vendors.*') ? 'bg-gray-700' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Vendors</span>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(isset($adminCounts['pending_vendors']) && $adminCounts['pending_vendors'] > 0)
                            <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $adminCounts['pending_vendors'] }}</span>
                            @endif
                            <span class="bg-gray-700 text-gray-300 text-xs px-2 py-0.5 rounded-full">{{ $adminCounts['vendors'] ?? 0 }}</span>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span>Products</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="bg-gray-700 text-gray-300 text-xs px-2 py-0.5 rounded-full">{{ $adminCounts['products'] ?? 0 }}</span>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <span>Orders</span>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(isset($adminCounts['pending_orders']) && $adminCounts['pending_orders'] > 0)
                            <span class="bg-yellow-500 text-gray-900 text-xs px-2 py-0.5 rounded-full font-semibold">{{ $adminCounts['pending_orders'] }}</span>
                            @endif
                            <span class="bg-gray-700 text-gray-300 text-xs px-2 py-0.5 rounded-full">{{ $adminCounts['orders'] ?? 0 }}</span>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span>Categories</span>
                        </div>
                        <span class="bg-gray-700 text-gray-300 text-xs px-2 py-0.5 rounded-full">{{ $adminCounts['categories'] ?? 0 }}</span>
                    </div>
                </a>
                
                <a href="{{ route('admin.home-sections.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.home-sections.*') ? 'bg-gray-700' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                            <span>Home Sections</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="bg-green-600 text-white text-xs px-2 py-0.5 rounded-full">{{ $adminCounts['active_sections'] ?? 0 }}</span>
                            <span class="bg-gray-700 text-gray-300 text-xs px-2 py-0.5 rounded-full">{{ $adminCounts['home_sections'] ?? 0 }}</span>
                        </div>
                    </div>
                </a>
                
                <div class="border-t border-gray-700 mt-4 pt-4">
                    <a href="{{ route('home') }}" class="block px-4 py-3 hover:bg-gray-700">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>View Store</span>
                        </div>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-gray-700">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </div>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>


