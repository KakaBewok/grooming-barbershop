<?php

namespace Database\Seeders;

use App\Models\Barbershop;
use App\Models\BarbershopImage;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Enums\ItemType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Grooming Admin',
            'email' => 'admin@grooming.com',
            'password' => bcrypt('rahasiabanget'),
        ]);

        // Create cashier user
        $cashier = User::factory()->create([
            'name' => 'Grooming Cashier',
            'email' => 'cashier@grooming.com',
            'password' => bcrypt('rahasiabangetjuga'),
        ]);

        $this->command->info('Database seeded successfully!');
    }
}