<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache duration in seconds
     */
    const DURATION_SHORT = 300;    // 5 minutes
    const DURATION_MEDIUM = 1800;  // 30 minutes
    const DURATION_LONG = 3600;    // 1 hour
    const DURATION_DAY = 86400;    // 24 hours

    /**
     * Cache keys
     */
    const KEY_CATEGORIES = 'categories.active';
    const KEY_FEATURED_PRODUCTS = 'products.featured';
    const KEY_DEALS = 'products.deals';
    const KEY_NEW_ARRIVALS = 'products.new_arrivals';
    const KEY_VENDORS_APPROVED = 'vendors.approved';
    const KEY_HOME_SECTIONS = 'home_sections.active';
    const KEY_STATS = 'stats.dashboard';

    /**
     * Get or set cache with callback
     */
    public static function remember(string $key, int $duration, callable $callback)
    {
        return Cache::remember($key, $duration, $callback);
    }

    /**
     * Get active categories with caching
     */
    public static function getActiveCategories()
    {
        return static::remember(
            static::KEY_CATEGORIES,
            static::DURATION_LONG,
            fn() => \App\Models\Category::where('is_active', true)
                ->withCount('products')
                ->orderBy('name')
                ->get()
        );
    }

    /**
     * Get featured products with caching
     */
    public static function getFeaturedProducts(int $limit = 8)
    {
        return static::remember(
            static::KEY_FEATURED_PRODUCTS . ".{$limit}",
            static::DURATION_MEDIUM,
            fn() => \App\Models\Product::active()
                ->featured()
                ->withCommonRelations()
                ->take($limit)
                ->get()
        );
    }

    /**
     * Get deals with caching
     */
    public static function getDeals(int $limit = 12)
    {
        return static::remember(
            static::KEY_DEALS . ".{$limit}",
            static::DURATION_MEDIUM,
            fn() => \App\Models\Product::active()
                ->onSale()
                ->withCommonRelations()
                ->whereRaw('(compare_price - price) / compare_price * 100 >= 30')
                ->orderByRaw('(compare_price - price) / compare_price DESC')
                ->take($limit)
                ->get()
        );
    }

    /**
     * Get new arrivals with caching
     */
    public static function getNewArrivals(int $limit = 8)
    {
        return static::remember(
            static::KEY_NEW_ARRIVALS . ".{$limit}",
            static::DURATION_SHORT,
            fn() => \App\Models\Product::active()
                ->withCommonRelations()
                ->latest()
                ->take($limit)
                ->get()
        );
    }

    /**
     * Get approved vendors with caching
     */
    public static function getApprovedVendors()
    {
        return static::remember(
            static::KEY_VENDORS_APPROVED,
            static::DURATION_LONG,
            fn() => \App\Models\Vendor::where('is_approved', true)
                ->where('is_active', true)
                ->select('id', 'shop_name', 'slug', 'logo')
                ->orderBy('shop_name')
                ->get()
        );
    }

    /**
     * Get active home sections with caching
     */
    public static function getHomeSections()
    {
        return static::remember(
            static::KEY_HOME_SECTIONS,
            static::DURATION_MEDIUM,
            fn() => \App\Models\HomeSection::active()
                ->orderBy('type')
                ->orderBy('order')
                ->get()
        );
    }

    /**
     * Get dashboard stats with caching
     */
    public static function getDashboardStats()
    {
        return static::remember(
            static::KEY_STATS,
            static::DURATION_SHORT,
            fn() => [
                'vendors' => \App\Models\Vendor::where('is_approved', true)->count(),
                'products' => \App\Models\Product::active()->count(),
                'categories' => \App\Models\Category::where('is_active', true)->count(),
                'orders_today' => \App\Models\Order::whereDate('created_at', today())->count(),
                'revenue_today' => \App\Models\Order::whereDate('created_at', today())->sum('total'),
            ]
        );
    }

    /**
     * Clear all application caches
     */
    public static function clearAll(): void
    {
        Cache::flush();
    }

    /**
     * Clear specific cache keys
     */
    public static function clearKey(string $key): void
    {
        Cache::forget($key);
    }

    /**
     * Clear product-related caches
     */
    public static function clearProductCaches(): void
    {
        static::clearKey(static::KEY_FEATURED_PRODUCTS);
        static::clearKey(static::KEY_DEALS);
        static::clearKey(static::KEY_NEW_ARRIVALS);
        static::clearKey(static::KEY_STATS);
        
        // Clear variant keys
        for ($i = 1; $i <= 20; $i++) {
            static::clearKey(static::KEY_FEATURED_PRODUCTS . ".{$i}");
            static::clearKey(static::KEY_DEALS . ".{$i}");
            static::clearKey(static::KEY_NEW_ARRIVALS . ".{$i}");
        }
    }

    /**
     * Clear category-related caches
     */
    public static function clearCategoryCaches(): void
    {
        static::clearKey(static::KEY_CATEGORIES);
    }

    /**
     * Clear vendor-related caches
     */
    public static function clearVendorCaches(): void
    {
        static::clearKey(static::KEY_VENDORS_APPROVED);
    }

    /**
     * Clear home section caches
     */
    public static function clearHomeSectionCaches(): void
    {
        static::clearKey(static::KEY_HOME_SECTIONS);
    }

    /**
     * Warm up cache (preload commonly used data)
     */
    public static function warmUp(): void
    {
        static::getActiveCategories();
        static::getFeaturedProducts();
        static::getDeals();
        static::getNewArrivals();
        static::getApprovedVendors();
        static::getHomeSections();
        static::getDashboardStats();
    }
}

