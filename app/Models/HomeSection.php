<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'description',
        'badge',
        'button_text',
        'button_link',
        'image',
        'gradient',
        'order',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    // Type constants
    const TYPE_HERO_SLIDE = 'hero_slide';
    const TYPE_CTA_BANNER = 'cta_banner';
    const TYPE_TOP_BAR = 'top_bar';

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeHeroSlides($query)
    {
        return $query->where('type', self::TYPE_HERO_SLIDE)->active()->orderBy('order');
    }

    public function scopeCtaBanners($query)
    {
        return $query->where('type', self::TYPE_CTA_BANNER)->active()->orderBy('order');
    }

    public function scopeTopBar($query)
    {
        return $query->where('type', self::TYPE_TOP_BAR)->active()->first();
    }
}
