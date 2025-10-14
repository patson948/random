<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'quantity',
        'sku',
        'images',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'images' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Append computed attributes
    protected $appends = ['main_image', 'in_stock'];

    // ==================== Relationships ====================

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ==================== Query Scopes ====================

    /**
     * Scope for active products only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for in-stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope for products on sale
     */
    public function scopeOnSale($query)
    {
        return $query->whereNotNull('compare_price')
                    ->whereRaw('compare_price > price');
    }

    /**
     * Scope for category filter
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope for vendor filter
     */
    public function scopeByVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    /**
     * Scope for price range filter
     */
    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('price', '>=', $min);
        }
        if ($max) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    /**
     * Scope with all common relationships (use for listing pages)
     */
    public function scopeWithCommonRelations($query)
    {
        return $query->with(['vendor', 'category'])
                    ->withCount('reviews')
                    ->withAvg('reviews', 'rating');
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%");
        });
    }

    // ==================== Route Binding ====================

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ==================== Attributes ====================

    public function getMainImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    /**
     * Get average rating with caching (uses withAvg in queries)
     */
    public function getAverageRatingAttribute(): float
    {
        // If loaded via withAvg, use that
        if (isset($this->attributes['reviews_avg_rating'])) {
            return round((float) $this->attributes['reviews_avg_rating'], 1);
        }

        // Otherwise calculate (use with caution - causes N+1)
        return Cache::remember("product.{$this->id}.avg_rating", 3600, function () {
            return round($this->reviews()->avg('rating') ?? 0, 1);
        });
    }

    /**
     * Get review count with caching (uses withCount in queries)
     */
    public function getReviewCountAttribute(): int
    {
        // If loaded via withCount, use that
        if (isset($this->attributes['reviews_count'])) {
            return (int) $this->attributes['reviews_count'];
        }

        // Otherwise calculate (use with caution - causes N+1)
        return Cache::remember("product.{$this->id}.review_count", 3600, function () {
            return $this->reviews()->count();
        });
    }

    public function getInStockAttribute(): bool
    {
        return $this->quantity > 0;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->compare_price || $this->compare_price <= $this->price) {
            return 0;
        }

        return (int) round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }

    // ==================== Cache Helpers ====================

    /**
     * Clear product cache
     */
    public function clearCache(): void
    {
        Cache::forget("product.{$this->id}.avg_rating");
        Cache::forget("product.{$this->id}.review_count");
    }

    /**
     * Boot method to clear cache on update
     */
    protected static function booted()
    {
        static::updated(function ($product) {
            $product->clearCache();
        });

        static::deleted(function ($product) {
            $product->clearCache();
        });
    }
}



