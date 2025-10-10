<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="aspect-w-1 aspect-h-1 bg-gray-200 dark:bg-gray-700 relative">
            @if($product->images && count($product->images) > 0)
                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 flex items-center justify-center">
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
            
            @if($product->is_featured)
                <span class="absolute top-2 left-2 bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-1 rounded">
                    Featured
                </span>
            @endif
            
            @if($product->compare_price && $product->compare_price > $product->price)
                @php
                    $discount = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
                @endphp
                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                    -{{ $discount }}%
                </span>
            @endif
        </div>
        
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 truncate">{{ $product->name }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 truncate">{{ $product->vendor->shop_name }}</p>
            
            <div class="flex items-center mb-3">
                <div class="flex text-yellow-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($product->average_rating))
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ $product->review_count }})</span>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">ZMW {{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price && $product->compare_price > $product->price)
                        <span class="text-sm text-gray-500 line-through ml-2">ZMW {{ number_format($product->compare_price, 2) }}</span>
                    @endif
                </div>
            </div>
            
            @if(!$product->in_stock)
                <p class="text-red-500 text-sm mt-2 font-semibold">Out of Stock</p>
            @endif
        </div>
    </a>
</div>


