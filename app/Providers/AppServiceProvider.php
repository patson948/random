<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\Order;
use App\Models\Product;
use App\Models\Vendor;
use App\Policies\CartPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Cart::class, CartPolicy::class);

        // Share cart count with all views
        view()->composer('*', function ($view) {
            try {
                if (auth()->check()) {
                    $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
                } else {
                    $cartCount = Cart::where('session_id', session()->getId())->sum('quantity');
                }
                $view->with('cartCount', $cartCount ?? 0);
            } catch (\Exception $e) {
                $view->with('cartCount', 0);
                \Log::error('Cart count error: ' . $e->getMessage());
            }
        });

        // Share admin sidebar counts with admin layout
        view()->composer('layouts.admin', function ($view) {
            try {
                $adminCounts = [
                    'vendors' => Vendor::count(),
                    'pending_vendors' => Vendor::where('is_approved', false)->count(),
                    'products' => Product::count(),
                    'active_products' => Product::where('is_active', true)->count(),
                    'orders' => Order::count(),
                    'pending_orders' => Order::where('status', 'pending')->count(),
                    'categories' => Category::count(),
                    'home_sections' => HomeSection::count(),
                    'active_sections' => HomeSection::where('is_active', true)->count(),
                ];
                $view->with('adminCounts', $adminCounts);
            } catch (\Exception $e) {
                $view->with('adminCounts', [
                    'vendors' => 0,
                    'pending_vendors' => 0,
                    'products' => 0,
                    'active_products' => 0,
                    'orders' => 0,
                    'pending_orders' => 0,
                    'categories' => 0,
                    'home_sections' => 0,
                    'active_sections' => 0,
                ]);
                \Log::error('Admin counts error: ' . $e->getMessage());
            }
        });
    }
}
