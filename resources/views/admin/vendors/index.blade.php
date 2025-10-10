<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendors Management - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }">
    @include('admin.layouts.sidebar')

    <div class="lg:pl-64">
        @include('admin.layouts.header')

        <main class="p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Vendors Management</h1>
                    <p class="text-gray-600">Manage vendor stores and approvals</p>
                </div>
                <div class="flex gap-3">
                    <button class="px-6 py-3 border border-gray-300 rounded-full font-medium hover:bg-gray-50 transition">
                        Export List
                    </button>
                    <a href="{{ route('admin.vendors.create') }}" class="bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                        + Invite Vendor
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Total Vendors</h3>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">24</p>
                    <p class="text-sm text-green-600 mt-2">+3 this month</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Active</h3>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">20</p>
                    <p class="text-sm text-gray-600 mt-2">83% of total</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Pending Approval</h3>
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">3</p>
                    <p class="text-sm text-yellow-600 mt-2">Requires action</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">Suspended</h3>
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">1</p>
                    <p class="text-sm text-gray-600 mt-2">Under review</p>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('admin.vendors.index') }}" class="bg-white rounded-2xl p-6 mb-6 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Shop name, email..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-black text-white px-6 py-2 rounded-xl font-medium hover:bg-gray-800 transition">
                            Filter
                        </button>
                        <a href="{{ route('admin.vendors.index') }}" class="px-6 py-2 border border-gray-300 rounded-xl font-medium hover:bg-gray-50 transition">
                            Clear
                        </a>
                    </div>
                </div>
            </form>

            <!-- Vendors Table -->
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Vendor</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Contact</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Products</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Revenue</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Commission</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Joined</th>
                                <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendors as $vendor)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        @if($vendor->logo)
                                            <img src="{{ asset('storage/' . $vendor->logo) }}" alt="{{ $vendor->shop_name }}" class="w-12 h-12 rounded-xl object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($vendor->shop_name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold">{{ $vendor->shop_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $vendor->description ? Str::limit($vendor->description, 30) : 'Vendor Store' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm">{{ $vendor->user->email }}</p>
                                    <p class="text-xs text-gray-500">{{ $vendor->phone ?? 'No phone' }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-sm font-semibold">{{ $vendor->products->count() }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-sm font-semibold">ZMW 0</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-sm">ZMW 0</span>
                                    <p class="text-xs text-gray-500">{{ $vendor->commission_rate }}%</p>
                                </td>
                                <td class="py-4 px-6">
                                    @if($vendor->is_approved)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pending</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-sm">{{ $vendor->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.vendors.show', $vendor) }}" class="text-sm text-blue-600 hover:underline">View</a>
                                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="text-sm text-black hover:underline">Edit</a>
                                        @if(!$vendor->is_approved)
                                        <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-sm text-green-600 hover:underline">Approve</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-gray-500">No vendors found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($vendors->hasPages())
                <div class="p-6 border-t">
                    {{ $vendors->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>

