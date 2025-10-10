<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with(['vendor', 'category'])
            ->take(8)
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->with(['vendor', 'category'])
            ->latest()
            ->take(12)
            ->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->take(8)
            ->get();

        return view('shop.home', compact('featuredProducts', 'latestProducts', 'categories'));
    }
}


