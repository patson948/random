<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@shophub.com')->first();
        $products = Product::where('is_active', true)->get();

        if (!$customer || $products->isEmpty()) {
            $this->command->warn('⚠️ Please run UserSeeder and ProductSeeder first!');
            return;
        }

        // Add 3 random products to demo customer's cart
        $cartProducts = $products->random(min(3, $products->count()));
        
        foreach ($cartProducts as $product) {
            Cart::create([
                'user_id' => $customer->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 3),
            ]);
        }
    }
}

