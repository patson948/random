<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Management - Admin</title>
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
                    <h1 class="text-3xl font-bold mb-2">Customers Management</h1>
                    <p class="text-gray-600">Manage customer accounts</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                    + Add Customer
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white rounded-2xl p-6 mb-6 border border-gray-100">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-black text-white px-6 py-2 rounded-xl font-medium hover:bg-gray-800 transition">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Customers Table -->
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Customer</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Email</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Orders</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Joined</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                                <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-semibold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">{{ $user->email }}</td>
                                <td class="py-4 px-6">{{ $user->orders_count }}</td>
                                <td class="py-4 px-6">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="py-4 px-6">
                                    @if($user->is_active)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-sm text-blue-600 hover:underline">View</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-sm text-black hover:underline">Edit</a>
                                        <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-sm text-gray-600 hover:text-black">
                                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500">No customers found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t">
                    {{ $users->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>

