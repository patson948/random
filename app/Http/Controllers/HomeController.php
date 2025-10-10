<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Get new arrivals (latest products)
        $newArrivals = Product::with(['category', 'reviews'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        // Get deals (products with significant discounts)
        $deals = Product::with(['category', 'reviews'])
            ->where('is_active', true)
            ->whereNotNull('compare_price')
            ->whereRaw('(compare_price - price) / compare_price * 100 >= 30')
            ->orderByRaw('(compare_price - price) / compare_price DESC')
            ->take(12)
            ->get();

        // Get top selling products (based on order items count or featured)
        $topSelling = Product::with(['category', 'reviews'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(4)
            ->get();

        // Get featured categories
        $featuredCategories = Category::where('is_active', true)
            ->withCount('products')
            ->take(6)
            ->get();

        // Get fashion category products
        $fashionProducts = Product::with(['category', 'reviews'])
            ->where('is_active', true)
            ->whereHas('category', function($query) {
                $query->whereIn('name', ['Fashion', 'Men', 'Women', 'Clothing']);
            })
            ->take(4)
            ->get();

        // Calculate stats
        $stats = [
            'vendors' => Vendor::where('is_approved', true)->count(),
            'products' => Product::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
        ];

        return view('index', compact('newArrivals', 'deals', 'topSelling', 'featuredCategories', 'fashionProducts', 'stats'));
    }
}

