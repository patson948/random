<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'vendor', 'reviews'])
            ->where('is_active', true);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sale') && $request->sale == 1) {
            $query->whereNotNull('compare_price')
                ->whereRaw('compare_price > price');
        }

        if ($request->has('featured') && $request->featured == 1) {
            $query->where('is_featured', true);
        }

        $perPage = $request->get('per_page', 20);
        $products = $query->latest()->paginate($perPage);

        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'vendor', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json($product);
    }

    public function home(Request $request)
    {
        // Get new arrivals
        $newArrivals = Product::with(['category', 'vendor', 'reviews'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        // Get deals
        $deals = Product::with(['category', 'vendor', 'reviews'])
            ->where('is_active', true)
            ->whereNotNull('compare_price')
            ->whereRaw('(compare_price - price) / compare_price * 100 >= 30')
            ->orderByRaw('(compare_price - price) / compare_price DESC')
            ->take(12)
            ->get();

        // Get featured products
        $featured = Product::with(['category', 'vendor', 'reviews'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(8)
            ->get();

        // Get categories
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->take(6)
            ->get();

        // Stats
        $stats = [
            'vendors' => Vendor::where('is_approved', true)->count(),
            'products' => Product::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
        ];

        return response()->json([
            'newArrivals' => $newArrivals,
            'deals' => $deals,
            'featured' => $featured,
            'categories' => $categories,
            'stats' => $stats,
        ]);
    }

    public function search(Request $request)
    {
        $query = Product::with(['category', 'vendor', 'reviews'])
            ->where('is_active', true);

        if ($request->has('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('short_description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(20);

        return response()->json($products);
    }
}


