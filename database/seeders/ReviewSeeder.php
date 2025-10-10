<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $customers = User::where('role', 'customer')->get();

        if ($products->isEmpty() || $customers->isEmpty()) {
            $this->command->warn('⚠️ Please run ProductSeeder and UserSeeder first!');
            return;
        }

        $reviewTexts = [
            ['rating' => 5, 'text' => 'Excellent product! Exactly as described and great quality.'],
            ['rating' => 5, 'text' => 'Love it! Fast delivery and amazing quality. Highly recommend!'],
            ['rating' => 5, 'text' => 'Perfect! This exceeded my expectations. Will buy again!'],
            ['rating' => 5, 'text' => 'Outstanding quality! Best purchase I\'ve made this year.'],
            ['rating' => 5, 'text' => 'Absolutely fantastic! Worth every penny. Five stars!'],
            ['rating' => 4, 'text' => 'Good product, value for money. Minor quality issues but overall satisfied.'],
            ['rating' => 4, 'text' => 'Great product! Delivery was a bit delayed but worth the wait.'],
            ['rating' => 4, 'text' => 'Very good product. Packaging could be better but item is great.'],
            ['rating' => 4, 'text' => 'Nice quality. Exactly what I needed. Would recommend!'],
            ['rating' => 3, 'text' => 'Okay product. It works but not as good as I expected.'],
            ['rating' => 3, 'text' => 'Average quality. Price is fair for what you get.'],
            ['rating' => 2, 'text' => 'Not quite what I expected. Quality could be better.'],
        ];

        foreach ($products as $product) {
            // Random number of reviews per product (0-6)
            $numReviews = rand(0, min(6, $customers->count()));
            
            // Get random customers without duplicates for this product
            $reviewCustomers = $customers->random(min($numReviews, $customers->count()));
            
            foreach ($reviewCustomers as $customer) {
                $reviewData = $reviewTexts[array_rand($reviewTexts)];
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $customer->id,
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['text'],
                    'is_approved' => rand(0, 9) > 0, // 90% approved
                ]);
            }
        }
    }
}

