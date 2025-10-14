<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Configure caching durations for different data types
    |
    */

    'cache' => [
        'enabled' => env('CACHE_ENABLED', true),
        
        'durations' => [
            'short' => 300,      // 5 minutes
            'medium' => 1800,    // 30 minutes  
            'long' => 3600,      // 1 hour
            'day' => 86400,      // 24 hours
            'week' => 604800,    // 7 days
        ],

        'keys' => [
            'categories' => 'categories.active',
            'products_featured' => 'products.featured',
            'products_deals' => 'products.deals',
            'products_new' => 'products.new_arrivals',
            'vendors' => 'vendors.approved',
            'home_sections' => 'home_sections.active',
            'stats' => 'stats.dashboard',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Query Optimization
    |--------------------------------------------------------------------------
    |
    | Settings for database query optimization
    |
    */

    'query' => [
        // Pagination settings
        'pagination' => [
            'products' => 20,
            'orders' => 20,
            'transactions' => 25,
            'reviews' => 15,
        ],

        // Eager load limits
        'eager_load_limits' => [
            'reviews' => 10,
            'related_products' => 4,
            'order_items' => 100,
        ],

        // Enable query logging in production (only for debugging)
        'log_queries' => env('LOG_QUERIES', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Optimization
    |--------------------------------------------------------------------------
    |
    | Settings for frontend asset optimization
    |
    */

    'assets' => [
        'cdn_url' => env('CDN_URL', null),
        'version' => env('ASSET_VERSION', '1.0.0'),
        'minify' => env('MINIFY_ASSETS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Optimization
    |--------------------------------------------------------------------------
    |
    | Settings for image handling and optimization
    |
    */

    'images' => [
        'max_upload_size' => 5120, // KB (5MB)
        'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
        'thumbnail_sizes' => [
            'small' => [150, 150],
            'medium' => [300, 300],
            'large' => [800, 800],
        ],
        'lazy_load' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Optimization
    |--------------------------------------------------------------------------
    |
    | Settings for session management
    |
    */

    'session' => [
        'driver' => env('SESSION_DRIVER', 'redis'), // Use redis/memcached in production
        'lifetime' => env('SESSION_LIFETIME', 120),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | API and request rate limiting settings
    |
    */

    'rate_limit' => [
        'api' => env('API_RATE_LIMIT', 60),        // requests per minute
        'search' => env('SEARCH_RATE_LIMIT', 30),   // searches per minute
        'auth' => env('AUTH_RATE_LIMIT', 5),        // login attempts per minute
    ],

    /*
    |--------------------------------------------------------------------------
    | Background Jobs
    |--------------------------------------------------------------------------
    |
    | Settings for queue and background processing
    |
    */

    'jobs' => [
        'queue_driver' => env('QUEUE_CONNECTION', 'redis'),
        'retry_after' => 90,
        'max_attempts' => 3,
    ],

];

