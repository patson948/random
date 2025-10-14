<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('🌱 Seeding ShopHub Database...');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        // Run seeders in order
        $this->call([
            UserSeeder::class,
            VendorSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ReviewSeeder::class,
            CartSeeder::class,
            OrderSeeder::class,
            HomeSectionSeeder::class,
        ]);

        // Display Summary
        $this->command->info('');
        $this->command->info('🎉 Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 Demo Accounts (Password: password):');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('👤 Admin:    admin@shophub.com');
        $this->command->info('🛍️  Customer: customer@shophub.com');
        $this->command->info('🏪 Vendor:   vendor@shophub.com');
        $this->command->info('💻 Tech:     tech@shophub.com');
        $this->command->info('🏠 Home:     home@shophub.com');
        $this->command->info('⚽ Sports:   sports@shophub.com');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('📊 Data Summary:');
        $this->command->info('   • ' . Vendor::count() . ' Vendor Stores');
        $this->command->info('   • ' . Category::count() . ' Categories');
        $this->command->info('   • ' . Product::count() . ' Products');
        $this->command->info('   • ' . User::where('role', 'customer')->count() . ' Customer Accounts');
        $this->command->info('   • ' . Review::count() . ' Product Reviews');
        $this->command->info('   • ' . Order::count() . ' Sample Orders');
        $this->command->info('');
        $this->command->info('✅ Ready to test at: http://localhost:8000');
        $this->command->info('');
    }
}
