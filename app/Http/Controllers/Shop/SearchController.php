<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::active()->withCommonRelations();

        // Search by keyword - optimized
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by vendor
        if ($request->filled('vendor')) {
            $query->byVendor($request->vendor);
        }

        // Filter by price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        // Filter by rating (optimized with having clause on already loaded avg)
        if ($request->filled('rating')) {
            $query->having('reviews_avg_rating', '>=', $request->rating);
        }

        // Filter by availability
        if ($request->filled('in_stock') && $request->in_stock == '1') {
            $query->inStock();
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

        // Get filter options - optimized
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();
            
        $vendors = Vendor::where('is_approved', true)
            ->select('id', 'shop_name', 'slug')
            ->orderBy('shop_name')
            ->get();

        return view('search-results', compact('products', 'categories', 'vendors'));
    }
}

