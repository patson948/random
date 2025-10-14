<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Slides
        HomeSection::create([
            'type' => HomeSection::TYPE_HERO_SLIDE,
            'title' => 'Fashion and offers for everybody',
            'description' => 'Discover the latest trends in fashion. Shop from thousands of trusted vendors across Africa.',
            'badge' => 'NEW COLLECTION',
            'button_text' => 'Start Shopping',
            'button_link' => '/search',
            'image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=800&q=80',
            'gradient' => 'from-gray-50 to-gray-100',
            'order' => 1,
            'is_active' => true,
        ]);

        HomeSection::create([
            'type' => HomeSection::TYPE_HERO_SLIDE,
            'title' => 'Save up to 50% on trending items',
            'description' => 'Limited time offers on your favorite brands. Don\'t miss out on these incredible deals!',
            'badge' => 'HOT DEALS',
            'button_text' => 'Shop Deals',
            'button_link' => '/deals',
            'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&q=80',
            'gradient' => 'from-red-50 to-orange-50',
            'order' => 2,
            'is_active' => true,
        ]);

        HomeSection::create([
            'type' => HomeSection::TYPE_HERO_SLIDE,
            'title' => 'Fresh styles for the new season',
            'description' => 'Explore our curated selection of trending essentials and make this season unforgettable.',
            'badge' => 'TRENDING NOW',
            'button_text' => 'Explore Collection',
            'button_link' => '/search',
            'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80',
            'gradient' => 'from-blue-50 to-cyan-50',
            'order' => 3,
            'is_active' => true,
        ]);

        // CTA Banners
        HomeSection::create([
            'type' => HomeSection::TYPE_CTA_BANNER,
            'title' => 'Up to 50% OFF',
            'description' => 'On selected items this season',
            'badge' => 'LIMITED OFFER',
            'button_text' => 'Shop Now',
            'button_link' => '/deals',
            'gradient' => 'from-indigo-500 to-purple-600',
            'order' => 1,
            'is_active' => true,
        ]);

        HomeSection::create([
            'type' => HomeSection::TYPE_CTA_BANNER,
            'title' => 'Summer Styles',
            'description' => 'Fresh arrivals for the season',
            'badge' => 'NEW COLLECTION',
            'button_text' => 'Discover More',
            'button_link' => '/search',
            'gradient' => 'from-orange-400 to-pink-500',
            'order' => 2,
            'is_active' => true,
        ]);

        // Top Bar
        HomeSection::create([
            'type' => HomeSection::TYPE_TOP_BAR,
            'title' => 'Free shipping on orders over ZMW 50,000',
            'order' => 1,
            'is_active' => true,
        ]);
    }
}
