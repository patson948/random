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
            if (auth()->check()) {
                $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
            } else {
                $cartCount = Cart::where('session_id', session()->getId())->sum('quantity');
            }
            $view->with('cartCount', $cartCount ?? 0);
        });

        // Share admin sidebar counts with admin layout
        view()->composer('layouts.admin', function ($view) {
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
        });
    }
}
