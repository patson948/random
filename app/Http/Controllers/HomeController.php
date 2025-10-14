<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\HomeSection;
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

        // Get main navigation categories
        $navCategories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('name')
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

        // Get dynamic sections from database
        $heroSlides = HomeSection::heroSlides()->get()->map(function($section) {
            return [
                'badge' => $section->badge,
                'title' => $section->title,
                'description' => $section->description,
                'image' => $section->image ?? 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=800&q=80',
                'gradient' => $section->gradient ?? 'from-gray-50 to-gray-100',
                'buttonText' => $section->button_text,
                'buttonLink' => $section->button_link
            ];
        });

        // If no hero slides in database, use fallback with product data
        if ($heroSlides->isEmpty()) {
            $heroSlides = collect();
            
            // First slide - New Collection
            $newArrivalImage = $newArrivals->first()->main_image ?? 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=800&q=80';
            
            $heroSlides->push([
                'badge' => 'NEW COLLECTION',
                'title' => 'Fashion and offers for everybody',
                'description' => 'Discover the latest trends in fashion. Shop from thousands of trusted vendors across Africa.',
                'image' => $newArrivalImage,
                'gradient' => 'from-gray-50 to-gray-100',
                'buttonText' => 'Start Shopping',
                'buttonLink' => '/search'
            ]);

            // Second slide - Deals (if available)
            if ($deals->count() > 0) {
                $dealsImage = $deals->first()->main_image ?? 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&q=80';
                
                $heroSlides->push([
                    'badge' => 'HOT DEALS',
                    'title' => 'Save up to 50% on trending items',
                    'description' => 'Limited time offers on your favorite brands. Don\'t miss out on these incredible deals!',
                    'image' => $dealsImage,
                    'gradient' => 'from-red-50 to-orange-50',
                    'buttonText' => 'Shop Deals',
                    'buttonLink' => '/deals'
                ]);
            }

            // Third slide - Fashion/Trending (if available)
            if ($fashionProducts->count() > 0) {
                $fashionImage = $fashionProducts->first()->main_image ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80';
                $categoryName = $fashionProducts->first()->category->name ?? 'fashion';
                
                $heroSlides->push([
                    'badge' => 'TRENDING NOW',
                    'title' => 'Fresh styles for the new season',
                    'description' => 'Explore our curated selection of trending essentials and make this season unforgettable.',
                    'image' => $fashionImage,
                    'gradient' => 'from-blue-50 to-cyan-50',
                    'buttonText' => 'Explore Collection',
                    'buttonLink' => '/search?category=' . strtolower($categoryName)
                ]);
            }
        }

        // Get CTA banners from database
        $ctaBanners = HomeSection::ctaBanners()->get();

        // Get top bar message
        $topBar = HomeSection::topBar();

        return view('index', compact('newArrivals', 'deals', 'topSelling', 'featuredCategories', 'navCategories', 'fashionProducts', 'stats', 'heroSlides', 'ctaBanners', 'topBar'));
    }
}

