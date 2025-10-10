@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-6">Welcome to ShopHub</h1>
            <p class="text-xl mb-8">Discover amazing products from trusted vendors</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Shop Now
            </a>
        </div>
    </div>
</div>

<!-- Categories Section -->
@if($categories->count() > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Shop by Category</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('category.show', $category) }}" class="group bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $category->products->count() }} products</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<div class="bg-gray-100 dark:bg-gray-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Latest Products -->
@if($latestProducts->count() > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Latest Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($latestProducts as $product)
            @include('components.product-card', ['product' => $product])
        @endforeach
    </div>
    <div class="text-center mt-8">
        <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            View All Products
        </a>
    </div>
</div>
@endif

<!-- Call to Action -->
<div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h2 class="text-3xl font-bold mb-4">Want to Sell on ShopHub?</h2>
        <p class="text-xl mb-8">Join thousands of vendors and start selling today!</p>
        <a href="{{ route('vendor.setup') }}" class="inline-block bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
            Become a Vendor
        </a>
    </div>
</div>
@endsection


