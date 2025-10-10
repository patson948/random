<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Men', 'description' => 'Fashion and accessories for men', 'icon' => '👔'],
            ['name' => 'Women', 'description' => 'Fashion and accessories for women', 'icon' => '👗'],
            ['name' => 'Kids', 'description' => 'Clothing and toys for children', 'icon' => '🧸'],
            ['name' => 'Electronics', 'description' => 'Smartphones, laptops and gadgets', 'icon' => '📱'],
            ['name' => 'Sports', 'description' => 'Sports equipment and fitness gear', 'icon' => '⚽'],
            ['name' => 'Home & Kitchen', 'description' => 'Home appliances and kitchen tools', 'icon' => '🏠'],
            ['name' => 'Beauty', 'description' => 'Cosmetics and personal care', 'icon' => '💄'],
            ['name' => 'Books', 'description' => 'Books and educational materials', 'icon' => '📚'],
        ];

        foreach ($categories as $index => $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }
}

