<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products = Product::where('is_active', true)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('⚠️ Please run UserSeeder and ProductSeeder first!');
            return;
        }

        $orderStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];
        $cities = ['Lagos', 'Abuja', 'Port Harcourt', 'Kano', 'Ibadan', 'Benin City'];
        $states = ['Lagos State', 'FCT', 'Rivers State', 'Kano State', 'Oyo State', 'Edo State'];

        // Create 15 sample orders
        for ($i = 0; $i < 15; $i++) {
            $customer = $customers->random();
            $orderProducts = $products->random(rand(1, 4));
            
            $subtotal = 0;
            $items = [];
            foreach ($orderProducts as $p) {
                $qty = rand(1, 2);
                $subtotal += $p->price * $qty;
                $items[] = ['product' => $p, 'qty' => $qty];
            }
            
            $tax = $subtotal * 0.075; // 7.5% VAT
            $shipping = $subtotal > 50000 ? 0 : 2500; // Free shipping over ₦50,000
            $total = $subtotal + $tax + $shipping;

            $cityIndex = array_rand($cities);

            $order = Order::create([
                'user_id' => $customer->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'status' => $orderStatuses[array_rand($orderStatuses)],
                'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                'payment_method' => rand(0, 1) ? 'lenco' : 'card',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'shipping_address' => json_encode([
                    'name' => $customer->name,
                    'phone' => '+234' . rand(8000000000, 8999999999),
                    'address' => rand(1, 100) . ' ' . ['Main Street', 'Park Avenue', 'Market Road', 'Independence Way'][array_rand(['Main Street', 'Park Avenue', 'Market Road', 'Independence Way'])],
                    'city' => $cities[$cityIndex],
                    'state' => $states[$cityIndex],
                    'country' => 'Nigeria',
                    'postal_code' => '10' . rand(0, 9) . '00' . rand(0, 9),
                ]),
                'notes' => rand(0, 3) ? null : ['Please handle with care', 'Ring doorbell upon delivery', 'Leave at security post'][rand(0, 2)],
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'vendor_id' => $item['product']->vendor_id,
                    'quantity' => $item['qty'],
                    'price' => $item['product']->price,
                    'total' => $item['product']->price * $item['qty'],
                ]);
            }
        }
    }
}

