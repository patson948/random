<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - Admin</title>
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
                    <h1 class="text-3xl font-bold mb-2">Products Management</h1>
                    <p class="text-gray-600">Manage all products across vendors</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-6 py-3 rounded-full font-medium hover:bg-gray-800 transition">
                    + Add Product
                </a>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl p-6 mb-6 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Search</label>
                        <input type="text" placeholder="Product name, SKU..." class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Category</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option>All Categories</option>
                            <option>Men</option>
                            <option>Women</option>
                            <option>Kids</option>
                            <option>Electronics</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Vendor</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option>All Vendors</option>
                            <option>StyleHub Fashion</option>
                            <option>TechVault</option>
                            <option>HomeComfort</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                            <option>Out of Stock</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Featured</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black">
                            <option>All Products</option>
                            <option>Featured Only</option>
                            <option>Non-Featured</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                <!-- Product Card -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden group hover:shadow-lg transition">
                    <div class="aspect-square bg-gray-100 relative overflow-hidden">
                        @if($product->is_featured)
                        <span class="absolute top-3 right-3 px-2 py-1 bg-purple-500 text-white text-xs font-medium rounded-full">Featured</span>
                        @endif
                        @if($product->compare_price && $product->compare_price > $product->price)
                        <span class="absolute top-3 left-3 px-2 py-1 bg-red-500 text-white text-xs font-medium rounded-full">Sale</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-500 mb-1">SKU: {{ $product->sku }}</p>
                        <h3 class="font-semibold mb-2">{{ Str::limit($product->name, 40) }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $product->vendor->shop_name }}</p>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-lg font-bold">ZMW {{ number_format($product->price, 2) }}</span>
                            <span class="text-sm {{ $product->quantity < 10 ? 'text-red-600' : 'text-gray-600' }}">Stock: {{ $product->quantity }}</span>
                        </div>
                        <div class="flex items-center gap-2 mb-3">
                            @if($product->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">Inactive</span>
                            @endif
                            @if($product->reviews->count() > 0)
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($product->reviews->avg('rating')))
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                                <span class="text-gray-500 ml-1">({{ number_format($product->reviews->avg('rating'), 1) }})</span>
                            </div>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.show', $product) }}" class="flex-1 text-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">View</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 text-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Edit</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="text-gray-500">No products found</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
        </main>
    </div>
</body>
</html>
