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

        Barbershop::factory()
            ->count(1)
            ->create()
            ->each(function ($barbershop) use ($admin, $cashier) {
                
                // Create 5-8 barbershop gallery images
                BarbershopImage::factory()
                    ->count(rand(5, 8))
                    ->create([
                        'barbershop_id' => $barbershop->id,
                    ]);

                // Create 8-12 services for each barbershop
                Service::factory()
                    ->count(rand(8, 12))
                    ->create([
                        'barbershop_id' => $barbershop->id,
                    ])
                    ->each(function ($service) {
                        // Create 2-4 images per service
                        ServiceImage::factory()
                            ->count(rand(2, 4))
                            ->create([
                                'service_id' => $service->id,
                            ]);

                        // Set one as primary
                        $service->images()->first()->update(['is_primary' => true]);
                    });

                // Create 10-15 products for each barbershop
                Product::factory()
                    ->count(rand(10, 15))
                    ->create([
                        'barbershop_id' => $barbershop->id,
                    ])
                    ->each(function ($product) {
                        // Create 2-5 images per product
                        ProductImage::factory()
                            ->count(rand(2, 5))
                            ->create([
                                'product_id' => $product->id,
                            ]);

                        // Set one as primary
                        $product->images()->first()->update(['is_primary' => true]);
                    });

                // Create 20-30 orders for each barbershop
                Order::factory()
                    ->count(rand(20, 30))
                    ->create([
                        'barbershop_id' => $barbershop->id,
                        'created_by' => rand(0, 1) ? $admin->id : $cashier->id,
                    ])
                    ->each(function ($order) use ($barbershop) {
                        // Get random products and services from this barbershop
                        $products = $barbershop->products()->active()->inRandomOrder()->limit(rand(0, 3))->get();
                        $services = $barbershop->services()->active()->inRandomOrder()->limit(rand(1, 2))->get();

                        // Add services to order
                        foreach ($services as $service) {
                            OrderItem::create([
                                'order_id' => $order->id,
                                'item_type' => ItemType::SERVICE,
                                'item_id' => $service->id,
                                'item_name' => $service->name,
                                'price' => $service->price,
                                'quantity' => 1,
                                'subtotal' => $service->price,
                            ]);
                        }

                        // Add products to order
                        foreach ($products as $product) {
                            $quantity = rand(1, 3);
                            OrderItem::create([
                                'order_id' => $order->id,
                                'item_type' => ItemType::PRODUCT,
                                'item_id' => $product->id,
                                'item_name' => $product->name,
                                'price' => $product->price,
                                'quantity' => $quantity,
                                'subtotal' => $product->price * $quantity,
                            ]);
                        }

                        // Recalculate order total
                        $order->calculateTotal();
                    });
            });

        $this->command->info('Database seeded successfully!');
    }
}