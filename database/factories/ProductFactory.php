<?php

namespace Database\Factories;

use App\Models\Barbershop;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    private static $productNames = [
        'Premium Pomade',
        'Hair Wax',
        'Hair Clay',
        'Beard Oil',
        'Beard Balm',
        'Aftershave Lotion',
        'Hair Tonic',
        'Shampoo',
        'Conditioner',
        'Hair Gel',
        'Styling Cream',
        'Sea Salt Spray',
    ];

    public function definition(): array
    {
        $name = fake()->unique()->randomElement(self::$productNames);
        $price = fake()->randomFloat(2, 50000, 500000);
        $hasDiscount = fake()->boolean(40);
        
        return [
            'barbershop_id' => Barbershop::factory(),
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->paragraph(2),
            'price' => $price,
            'crossed_out_price' => $hasDiscount ? $price * 1.3 : null,
            'stock' => fake()->numberBetween(0, 100),
            'is_active' => fake()->boolean(90),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }

    public function withDiscount(): static
    {
        return $this->state(function (array $attributes) {
            $price = $attributes['price'];
            return [
                'crossed_out_price' => $price * fake()->randomFloat(2, 1.2, 1.5),
            ];
        });
    }
}