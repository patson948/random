<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Product;
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
    }
}
