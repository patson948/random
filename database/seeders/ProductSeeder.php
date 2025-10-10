<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all();
        $categories = Category::all();

        if ($vendors->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('⚠️ Please run UserSeeder and CategorySeeder first!');
            return;
        }

        $productsData = [
            // Men's Fashion (Vendor 1 - StyleHub Fashion)
            ['vendor' => 0, 'category' => 'Men', 'name' => 'Gradient Graphic T-shirt', 'price' => 14500, 'compare' => 18000, 'qty' => 50, 'featured' => true],
            ['vendor' => 0, 'category' => 'Men', 'name' => 'Checkered Shirt', 'price' => 18000, 'compare' => null, 'qty' => 40, 'featured' => true],
            ['vendor' => 0, 'category' => 'Men', 'name' => 'Skinny Fit Jeans', 'price' => 24000, 'compare' => 32000, 'qty' => 60, 'featured' => true],
            ['vendor' => 0, 'category' => 'Men', 'name' => 'Sleeve Striped T-shirt', 'price' => 13000, 'compare' => 16000, 'qty' => 45, 'featured' => false],
            ['vendor' => 0, 'category' => 'Men', 'name' => 'Vertical Striped Shirt', 'price' => 21000, 'compare' => 26000, 'qty' => 35, 'featured' => false],
            ['vendor' => 0, 'category' => 'Men', 'name' => 'Courage Graphic T-shirt', 'price' => 14500, 'compare' => null, 'qty' => 55, 'featured' => false],
            ['vendor' => 0, 'category' => 'Men', 'name' => 'Loose Fit Bermuda Shorts', 'price' => 8000, 'compare' => 12000, 'qty' => 70, 'featured' => false],
            
            // Women's Fashion (Vendor 1 - StyleHub Fashion)
            ['vendor' => 0, 'category' => 'Women', 'name' => 'Floral Summer Dress', 'price' => 32000, 'compare' => 45000, 'qty' => 30, 'featured' => true],
            ['vendor' => 0, 'category' => 'Women', 'name' => 'Designer Handbag', 'price' => 48000, 'compare' => 65000, 'qty' => 20, 'featured' => true],
            ['vendor' => 0, 'category' => 'Women', 'name' => 'High Heels Sandals', 'price' => 28000, 'compare' => 38000, 'qty' => 25, 'featured' => false],
            ['vendor' => 0, 'category' => 'Women', 'name' => 'Casual Blazer', 'price' => 42000, 'compare' => null, 'qty' => 18, 'featured' => false],
            ['vendor' => 0, 'category' => 'Women', 'name' => 'Leather Crossbody Bag', 'price' => 35000, 'compare' => 48000, 'qty' => 22, 'featured' => false],
            
            // Kids (Vendor 1 - StyleHub Fashion)
            ['vendor' => 0, 'category' => 'Kids', 'name' => 'Kids Cartoon T-shirt Set', 'price' => 12000, 'compare' => 16000, 'qty' => 80, 'featured' => false],
            ['vendor' => 0, 'category' => 'Kids', 'name' => 'Children Sneakers', 'price' => 15000, 'compare' => 20000, 'qty' => 45, 'featured' => false],
            ['vendor' => 0, 'category' => 'Kids', 'name' => 'Kids Denim Jacket', 'price' => 18000, 'compare' => 25000, 'qty' => 35, 'featured' => false],
            
            // Electronics (Vendor 2 - TechVault)
            ['vendor' => 1, 'category' => 'Electronics', 'name' => 'Wireless Bluetooth Earbuds', 'price' => 35000, 'compare' => 50000, 'qty' => 60, 'featured' => true],
            ['vendor' => 1, 'category' => 'Electronics', 'name' => 'Smart Watch Pro', 'price' => 75000, 'compare' => 95000, 'qty' => 25, 'featured' => true],
            ['vendor' => 1, 'category' => 'Electronics', 'name' => 'Power Bank 20000mAh', 'price' => 12000, 'compare' => 18000, 'qty' => 100, 'featured' => false],
            ['vendor' => 1, 'category' => 'Electronics', 'name' => 'USB-C Fast Charger', 'price' => 8500, 'compare' => null, 'qty' => 150, 'featured' => false],
            ['vendor' => 1, 'category' => 'Electronics', 'name' => 'Wireless Mouse', 'price' => 6500, 'compare' => 9000, 'qty' => 90, 'featured' => false],
            ['vendor' => 1, 'category' => 'Electronics', 'name' => 'Mechanical Keyboard RGB', 'price' => 45000, 'compare' => 65000, 'qty' => 30, 'featured' => true],
            ['vendor' => 1, 'category' => 'Electronics', 'name' => 'Webcam Full HD', 'price' => 28000, 'compare' => 38000, 'qty' => 40, 'featured' => false],
            
            // Sports (Vendor 4 - ActiveLife Sports)
            ['vendor' => 3, 'category' => 'Sports', 'name' => 'Yoga Mat Premium', 'price' => 15000, 'compare' => 22000, 'qty' => 50, 'featured' => false],
            ['vendor' => 3, 'category' => 'Sports', 'name' => 'Running Shoes Pro', 'price' => 45000, 'compare' => 60000, 'qty' => 35, 'featured' => true],
            ['vendor' => 3, 'category' => 'Sports', 'name' => 'Dumbbell Set 20kg', 'price' => 38000, 'compare' => null, 'qty' => 20, 'featured' => false],
            ['vendor' => 3, 'category' => 'Sports', 'name' => 'Resistance Bands Set', 'price' => 12000, 'compare' => 18000, 'qty' => 65, 'featured' => false],
            ['vendor' => 3, 'category' => 'Sports', 'name' => 'Jump Rope Speed', 'price' => 5000, 'compare' => 8000, 'qty' => 100, 'featured' => false],
            
            // Home & Kitchen (Vendor 3 - HomeComfort)
            ['vendor' => 2, 'category' => 'Home & Kitchen', 'name' => 'Blender 1000W', 'price' => 25000, 'compare' => 35000, 'qty' => 40, 'featured' => false],
            ['vendor' => 2, 'category' => 'Home & Kitchen', 'name' => 'Non-stick Cookware Set', 'price' => 48000, 'compare' => 65000, 'qty' => 30, 'featured' => true],
            ['vendor' => 2, 'category' => 'Home & Kitchen', 'name' => 'Electric Kettle 2L', 'price' => 12000, 'compare' => 16000, 'qty' => 55, 'featured' => false],
            ['vendor' => 2, 'category' => 'Home & Kitchen', 'name' => 'Microwave Oven', 'price' => 85000, 'compare' => 110000, 'qty' => 15, 'featured' => true],
            ['vendor' => 2, 'category' => 'Home & Kitchen', 'name' => 'Air Fryer 5L', 'price' => 58000, 'compare' => 78000, 'qty' => 25, 'featured' => true],
            ['vendor' => 2, 'category' => 'Home & Kitchen', 'name' => 'Coffee Maker', 'price' => 32000, 'compare' => 45000, 'qty' => 35, 'featured' => false],
        ];

        foreach ($productsData as $pData) {
            $vendor = $vendors->get($pData['vendor']);
            $category = $categories->where('name', $pData['category'])->first();

            if (!$vendor || !$category) {
                continue;
            }

            Product::create([
                'vendor_id' => $vendor->id,
                'category_id' => $category->id,
                'name' => $pData['name'],
                'slug' => Str::slug($pData['name']) . '-' . Str::random(6),
                'description' => 'This is a high-quality ' . strtolower($pData['name']) . ' designed for comfort and style. Made with premium materials and attention to detail, this product offers excellent value for money and is perfect for everyday use. Whether you\'re looking for durability, functionality, or aesthetics, this product delivers on all fronts.',
                'short_description' => 'Premium ' . strtolower($pData['name']) . ' with excellent quality',
                'price' => $pData['price'],
                'compare_price' => $pData['compare'],
                'quantity' => $pData['qty'],
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'is_featured' => $pData['featured'],
                'is_active' => true,
            ]);
        }
    }
}

