<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@shophub.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Demo Customer User
        User::factory()->create([
            'name' => 'John Customer',
            'email' => 'customer@shophub.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Create Additional Customer Users
        User::factory()->count(8)->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Create Vendor Users with their stores
        $vendorUsers = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'vendor@shophub.com',
                'shop_name' => 'StyleHub Fashion',
                'description' => 'Premium fashion and lifestyle products for modern individuals',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'tech@shophub.com',
                'shop_name' => 'TechVault',
                'description' => 'Latest gadgets, electronics and tech accessories',
            ],
            [
                'name' => 'Amara Okafor',
                'email' => 'home@shophub.com',
                'shop_name' => 'HomeComfort',
                'description' => 'Quality home essentials and kitchen appliances',
            ],
            [
                'name' => 'David Williams',
                'email' => 'sports@shophub.com',
                'shop_name' => 'ActiveLife Sports',
                'description' => 'Sports equipment and fitness gear for active lifestyles',
            ],
        ];

        foreach ($vendorUsers as $vendorData) {
            $user = User::factory()->create([
                'name' => $vendorData['name'],
                'email' => $vendorData['email'],
                'password' => bcrypt('password'),
                'role' => 'vendor',
                'is_active' => true,
            ]);

            Vendor::create([
                'user_id' => $user->id,
                'shop_name' => $vendorData['shop_name'],
                'slug' => Str::slug($vendorData['shop_name']),
                'description' => $vendorData['description'],
                'phone' => '+234' . rand(8000000000, 8999999999),
                'address' => rand(1, 100) . ' Main Street, Victoria Island, Lagos, Nigeria',
                'commission_rate' => rand(5, 15) + (rand(0, 99) / 100),
                'is_approved' => true,
            ]);
        }
    }
}

