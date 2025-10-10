<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true }">
    @include('admin.layouts.sidebar')

    <!-- Main Content -->
    <div class="lg:pl-64">
        @include('admin.layouts.header')

        <!-- Page Content -->
        <main class="p-6">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-2">Orders Management</h1>
                <p class="text-gray-600">View and manage all customer orders</p>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-2xl p-6 mb-6 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Search</label>
                        <input type="text" placeholder="Order ID, Customer..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Processing</option>
                            <option>Shipped</option>
                            <option>Delivered</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Payment Status</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option>All Payments</option>
                            <option>Paid</option>
                            <option>Pending</option>
                            <option>Failed</option>
                            <option>Refunded</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Date Range</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 90 days</option>
                            <option>All time</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Order ID</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Customer</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Date</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Items</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Total</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                                <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Payment</th>
                                <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-purple-100 text-purple-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $paymentColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'paid' => 'bg-green-100 text-green-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                    'refunded' => 'bg-gray-100 text-gray-700',
                                ];
                            @endphp
                            @forelse($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <span class="font-medium text-sm">{{ $order->order_number }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="text-sm font-medium">{{ $order->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm">{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-sm">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-sm font-semibold">ZMW {{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }} text-xs font-medium rounded-full">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-700' }} text-xs font-medium rounded-full">{{ ucfirst($order->payment_status) }}</span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-sm text-black hover:underline">View Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-gray-500">No orders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="p-6 border-t">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>

