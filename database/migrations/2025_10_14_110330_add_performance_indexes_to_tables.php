<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add database indexes for optimized query performance
     */
    public function up(): void
    {
        // Products table indexes
        Schema::table('products', function (Blueprint $table) {
            $table->index('vendor_id');
            $table->index('category_id');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('price');
            $table->index('quantity');
            $table->index('created_at');
            $table->index(['is_active', 'created_at']); // Composite for listing active products
            $table->index(['is_active', 'is_featured']); // Composite for featured products
            $table->index(['category_id', 'is_active']); // Composite for category filtering
            $table->index(['vendor_id', 'is_active']); // Composite for vendor products
            $table->fullText(['name', 'description', 'sku']); // Full-text search
        });

        // Orders table indexes
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
            $table->index('payment_status');
            $table->index('created_at');
            $table->index(['user_id', 'status']); // Composite for user orders by status
            $table->index(['status', 'created_at']); // Composite for order listings
        });

        // Order Items table indexes
        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('product_id');
            $table->index('vendor_id');
            $table->index(['order_id', 'vendor_id']); // Composite for vendor order items
        });

        // Reviews table indexes
        Schema::table('reviews', function (Blueprint $table) {
            $table->index('product_id');
            $table->index('user_id');
            $table->index('rating');
            $table->index('created_at');
            $table->index(['product_id', 'rating']); // Composite for product reviews
        });

        // Carts table indexes
        Schema::table('carts', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('product_id');
            $table->index('session_id');
            $table->index(['user_id', 'product_id']); // Composite for user cart items
            $table->index(['session_id', 'product_id']); // Composite for guest cart items
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('parent_id');
            $table->index(['is_active', 'parent_id']); // Composite for active categories
        });

        // Vendors table indexes
        Schema::table('vendors', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('is_approved');
            $table->index('is_active');
            $table->index(['is_approved', 'is_active']); // Composite for approved active vendors
        });

        // Transactions table indexes
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('order_id');
            $table->index('status');
            $table->index('payment_method');
            $table->index('reference');
            $table->index('provider_reference');
            $table->index('created_at');
            $table->index(['user_id', 'status']); // Composite for user transactions
            $table->index(['order_id', 'status']); // Composite for order transactions
        });

        // Addresses table indexes
        Schema::table('addresses', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('is_default');
            $table->index(['user_id', 'is_default']); // Composite for user addresses
        });

        // Home Sections table indexes
        Schema::table('home_sections', function (Blueprint $table) {
            $table->index('type');
            $table->index('is_active');
            $table->index('order');
            $table->index(['type', 'is_active', 'order']); // Composite for section queries
        });

        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('is_active');
            $table->index(['role', 'is_active']); // Composite for role-based queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['vendor_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['price']);
            $table->dropIndex(['quantity']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['is_active', 'created_at']);
            $table->dropIndex(['is_active', 'is_featured']);
            $table->dropIndex(['category_id', 'is_active']);
            $table->dropIndex(['vendor_id', 'is_active']);
            $table->dropFullText(['name', 'description', 'sku']);
        });

        // Orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['status', 'created_at']);
        });

        // Order Items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['product_id']);
            $table->dropIndex(['vendor_id']);
            $table->dropIndex(['order_id', 'vendor_id']);
        });

        // Reviews table
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['rating']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['product_id', 'rating']);
        });

        // Carts table
        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['product_id']);
            $table->dropIndex(['session_id']);
            $table->dropIndex(['user_id', 'product_id']);
            $table->dropIndex(['session_id', 'product_id']);
        });

        // Categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['parent_id']);
            $table->dropIndex(['is_active', 'parent_id']);
        });

        // Vendors table
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_approved']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_approved', 'is_active']);
        });

        // Transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['order_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_method']);
            $table->dropIndex(['reference']);
            $table->dropIndex(['provider_reference']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['order_id', 'status']);
        });

        // Addresses table
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_default']);
            $table->dropIndex(['user_id', 'is_default']);
        });

        // Home Sections table
        Schema::table('home_sections', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['order']);
            $table->dropIndex(['type', 'is_active', 'order']);
        });

        // Users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['role', 'is_active']);
        });
    }
};
