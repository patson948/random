<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::active()->withCommonRelations();

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->byCategory($category->id);
            }
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->featured();
        }

        // Filter by on sale
        if ($request->filled('sale')) {
            $query->onSale();
        }

        // Sort
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('reviews_count', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(20)->withQueryString();
        
        // Optimize category loading with product count
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return view('search-results', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        // Optimize: Load relations with specific columns
        $product->load([
            'vendor:id,shop_name,slug,logo',
            'category:id,name,slug',
            'reviews' => function ($query) {
                $query->latest()
                      ->with('user:id,name,avatar')
                      ->take(10);
            }
        ]);
        
        // Get related products - optimized
        $relatedProducts = Product::active()
            ->byCategory($product->category_id)
            ->where('id', '!=', $product->id)
            ->withCommonRelations()
            ->limit(4)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}
