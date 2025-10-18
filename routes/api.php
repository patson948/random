<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public product routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/{product:slug}', [ProductController::class, 'show']);

// Public category routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

// Home data
Route::get('/home', [ProductController::class, 'home']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [UserController::class, 'profile']);
    Route::put('/user', [UserController::class, 'update']);
    Route::put('/user/password', [UserController::class, 'updatePassword']);
    
    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::get('/cart/count', [CartController::class, 'count']);
    Route::post('/cart', [CartController::class, 'add']);
    Route::put('/cart/{cart}', [CartController::class, 'update']);
    Route::delete('/cart/{cart}', [CartController::class, 'remove']);
    Route::delete('/cart', [CartController::class, 'clear']);
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    
    // Addresses
    Route::get('/addresses', [UserController::class, 'addresses']);
    Route::post('/addresses', [UserController::class, 'storeAddress']);
    Route::put('/addresses/{address}', [UserController::class, 'updateAddress']);
    Route::delete('/addresses/{address}', [UserController::class, 'destroyAddress']);
    
    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
        Route::get('/recent', [NotificationController::class, 'recent']);
        Route::get('/stats', [NotificationController::class, 'stats']);
        Route::get('/types', [NotificationController::class, 'types']);
        Route::get('/type/{type}', [NotificationController::class, 'byType']);
        Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead']);
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/{notification}', [NotificationController::class, 'destroy']);
        Route::delete('/', [NotificationController::class, 'destroyAll']);
    });
});

