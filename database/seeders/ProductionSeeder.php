<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Seed essential production data only.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@yourcompany.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@yourcompany.com', // CHANGE THIS
                'password' => Hash::make('ChangeThisPassword123!'), // CHANGE THIS
                'role' => 'admin',
                'is_active' => true,
            ]);
            
            $this->command->info('✅ Admin user created: admin@yourcompany.com');
            $this->command->warn('⚠️  IMPORTANT: Change the default password immediately!');
        }
    }
}

