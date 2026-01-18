<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Service;
use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $itemType = fake()->randomElement(ItemType::cases());
        
        if ($itemType === ItemType::PRODUCT) {
            $product = Product::factory()->create();
            $itemId = $product->id;
            $itemName = $product->name;
            $price = $product->price;
        } else {
            $service = Service::factory()->create();
            $itemId = $service->id;
            $itemName = $service->name;
            $price = $service->price;
        }

        $quantity = $itemType === ItemType::SERVICE ? 1 : fake()->numberBetween(1, 3);

        return [
            'order_id' => Order::factory(),
            'item_type' => $itemType,
            'item_id' => $itemId,
            'item_name' => $itemName,
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $price * $quantity,
        ];
    }

    public function product(): static
    {
        return $this->state(function (array $attributes) {
            $product = Product::factory()->create();
            $quantity = fake()->numberBetween(1, 3);
            
            return [
                'item_type' => ItemType::PRODUCT,
                'item_id' => $product->id,
                'item_name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
            ];
        });
    }

    public function service(): static
    {
        return $this->state(function (array $attributes) {
            $service = Service::factory()->create();
            
            return [
                'item_type' => ItemType::SERVICE,
                'item_id' => $service->id,
                'item_name' => $service->name,
                'price' => $service->price,
                'quantity' => 1,
                'subtotal' => $service->price,
            ];
        });
    }
}