<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('👥 Creating Vendors...');

        $vendors = [
            [
                'name' => 'Tech Store',
                'email' => 'tech@shophub.com',
                'shop_name' => 'TechHub Electronics',
                'description' => 'Your one-stop shop for all electronics and gadgets.',
                'phone' => '+260 97 123 4567',
                'commission_rate' => 10.00,
            ],
            [
                'name' => 'Fashion Boutique',
                'email' => 'fashion@shophub.com',
                'shop_name' => 'Style & Trends',
                'description' => 'Latest fashion trends for men, women, and kids.',
                'phone' => '+260 97 234 5678',
                'commission_rate' => 12.00,
            ],
            [
                'name' => 'Sports World',
                'email' => 'sports@shophub.com',
                'shop_name' => 'SportsPro',
                'description' => 'Quality sports equipment and athletic wear.',
                'phone' => '+260 97 345 6789',
                'commission_rate' => 11.00,
            ],
            [
                'name' => 'Home Essentials',
                'email' => 'home@shophub.com',
                'shop_name' => 'HomeCare Plus',
                'description' => 'Everything you need for your home.',
                'phone' => '+260 97 456 7890',
                'commission_rate' => 10.50,
            ],
        ];

        foreach ($vendors as $vendorData) {
            // Check if user already exists
            $existingUser = User::where('email', $vendorData['email'])->first();
            
            if ($existingUser) {
                $this->command->info("   ⚠️ User already exists: {$vendorData['shop_name']} ({$vendorData['email']})");
                continue;
            }

            // Create user account for vendor
            $user = User::create([
                'name' => $vendorData['name'],
                'email' => $vendorData['email'],
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            // Check if vendor profile already exists
            $existingVendor = Vendor::where('user_id', $user->id)->first();
            
            if (!$existingVendor) {
                // Create vendor profile
                Vendor::create([
                    'user_id' => $user->id,
                    'shop_name' => $vendorData['shop_name'],
                    'slug' => Str::slug($vendorData['shop_name']),
                    'description' => $vendorData['description'],
                    'phone' => $vendorData['phone'],
                    'commission_rate' => $vendorData['commission_rate'],
                    'is_approved' => true,
                ]);
            }

            $this->command->info("   ✓ {$vendorData['shop_name']} ({$vendorData['email']})");
        }
    }
}

