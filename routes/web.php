<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Shop Routes
Route::get('/products', [App\Http\Controllers\Shop\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [App\Http\Controllers\Shop\ProductController::class, 'show'])->name('products.show');
Route::get('/categories', [App\Http\Controllers\Shop\CategoryController::class, 'index'])->name('categories.index');
Route::get('/deals', [App\Http\Controllers\Shop\ProductController::class, 'index'])->name('deals')->defaults('sale', 1);

// Search
Route::get('/search', [App\Http\Controllers\Shop\SearchController::class, 'index'])->name('search');

// Footer Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Cart Routes
Route::get('/cart', [App\Http\Controllers\Shop\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [App\Http\Controllers\Shop\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cart}', [App\Http\Controllers\Shop\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [App\Http\Controllers\Shop\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [App\Http\Controllers\Shop\CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [App\Http\Controllers\Shop\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/save-address', [App\Http\Controllers\Shop\CheckoutController::class, 'saveAddress'])->name('checkout.save-address');
Route::post('/checkout', [App\Http\Controllers\Shop\CheckoutController::class, 'store'])->name('checkout.store');

// Payment Routes
Route::get('/payment', [App\Http\Controllers\Shop\PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment', [App\Http\Controllers\Shop\PaymentController::class, 'process'])->name('payment.process');

// Lenco Mobile Money Payment Routes
Route::get('/lenco/pay', [App\Http\Controllers\LencoPaymentController::class, 'showForm'])->name('lenco.form');
Route::post('/lenco/initiate', [App\Http\Controllers\LencoPaymentController::class, 'initiate'])->name('lenco.initiate');
Route::get('/lenco/status/{reference}', [App\Http\Controllers\LencoPaymentController::class, 'status'])->name('lenco.status');
Route::get('/lenco/otp/{reference}', [App\Http\Controllers\LencoPaymentController::class, 'showOtpForm'])->name('lenco.otp');
Route::post('/lenco/otp/{reference}', [App\Http\Controllers\LencoPaymentController::class, 'submitOtp'])->name('lenco.otp.submit');
Route::post('/lenco/timeout', [App\Http\Controllers\LencoPaymentController::class, 'handleTimeout'])->name('lenco.timeout');

// Order Success
Route::get('/order-success/{order}', function (App\Models\Order $order) {
    $order->load(['items', 'user']);
    return view('order-success', compact('order'));
})->name('order.success');

// Demo Routes
// Product details now uses: /products/{product} route

Route::get('/cart-demo', function () {
    return view('cart');
});

Route::get('/checkout-demo', function () {
    return view('checkout');
});

// ==========================================
// ⚠️ DEVELOPMENT/DEBUG ROUTES - REMOVE IN PRODUCTION
// ==========================================

// Social Auth Test Route (remove in production)
Route::get('/social-auth-test', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'provider' => $user->provider,
                'google_id' => $user->google_id,
                'facebook_id' => $user->facebook_id,
                'github_id' => $user->github_id,
                'avatar' => $user->avatar,
            ]
        ]);
    }
    return response()->json(['authenticated' => false]);
})->name('social.auth.test');

// Facebook OAuth Debug Route (remove in production)
Route::get('/facebook-debug', function () {
    $config = config('services.facebook');
    return response()->json([
        'facebook_config' => [
            'client_id' => $config['client_id'] ? 'Set' : 'Not Set',
            'client_secret' => $config['client_secret'] ? 'Set' : 'Not Set',
            'redirect' => $config['redirect'],
        ],
        'app_url' => config('app.url'),
        'facebook_redirect_url' => route('auth.facebook.callback'),
    ]);
})->name('facebook.debug');

Route::get('/payment-demo', function () {
    return view('payment');
});

Route::get('/order-success-demo', function () {
    return view('order-success');
});

Route::get('/categories-demo', function () {
    return view('categories');
});

// Route::get('/search-demo', function () {
//     return view('search-results');
// });

Route::get('/track-order-demo', function () {
    return view('track-order');
});

// ==========================================
// END DEBUG ROUTES
// ==========================================

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Orders Management
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Products Management
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    
    // Vendors Management
    Route::resource('vendors', App\Http\Controllers\Admin\VendorController::class);
    Route::post('/vendors/{vendor}/approve', [App\Http\Controllers\Admin\VendorController::class, 'approve'])->name('vendors.approve');
    Route::post('/vendors/{vendor}/reject', [App\Http\Controllers\Admin\VendorController::class, 'reject'])->name('vendors.reject');
    
    // Categories Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Home Sections Management
    Route::resource('home-sections', App\Http\Controllers\Admin\HomeSectionController::class);
    
    // Customers Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    
    // Transactions Management
    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/status', [App\Http\Controllers\Admin\TransactionController::class, 'updateStatus'])->name('transactions.update-status');
    
    // Profile Management
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

// Vendor Setup (before vendor middleware)
Route::middleware(['auth'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/setup', [App\Http\Controllers\Vendor\SetupController::class, 'show'])->name('setup');
    Route::post('/setup', [App\Http\Controllers\Vendor\SetupController::class, 'store'])->name('setup.store');
    Route::get('/pending', [App\Http\Controllers\Vendor\DashboardController::class, 'pending'])->name('pending');
});

// Vendor Routes (requires vendor role and approval)
Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Vendor\DashboardController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::resource('products', App\Http\Controllers\Vendor\ProductController::class);
    
    // Order Management
    Route::get('/orders', [App\Http\Controllers\Vendor\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Vendor\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Vendor\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Profile Management
    Route::get('/profile', [App\Http\Controllers\Vendor\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Vendor\ProfileController::class, 'update'])->name('profile.update');
});

// Customer Dashboard & Orders
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Customer\OrderController::class, 'show'])->name('customer.orders.show');
    
    // Address Management
    Route::get('/addresses', [App\Http\Controllers\Customer\AddressController::class, 'index'])->name('customer.addresses.index');
    Route::get('/addresses/create', [App\Http\Controllers\Customer\AddressController::class, 'create'])->name('customer.addresses.create');
    Route::post('/addresses', [App\Http\Controllers\Customer\AddressController::class, 'store'])->name('customer.addresses.store');
    Route::get('/addresses/{address}/edit', [App\Http\Controllers\Customer\AddressController::class, 'edit'])->name('customer.addresses.edit');
    Route::put('/addresses/{address}', [App\Http\Controllers\Customer\AddressController::class, 'update'])->name('customer.addresses.update');
    Route::delete('/addresses/{address}', [App\Http\Controllers\Customer\AddressController::class, 'destroy'])->name('customer.addresses.destroy');
    Route::post('/addresses/{address}/set-default', [App\Http\Controllers\Customer\AddressController::class, 'setDefault'])->name('customer.addresses.set-default');
});

Route::middleware('auth')->group(function () {
    // Customer Profile
    Route::get('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('customer.profile.update');
    Route::patch('/profile/password', [App\Http\Controllers\Customer\ProfileController::class, 'updatePassword'])->name('customer.profile.updatePassword');
    Route::delete('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'destroy'])->name('customer.profile.destroy');
});

require __DIR__.'/auth.php';
