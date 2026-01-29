<?php

namespace Database\Factories;

use App\Models\Barbershop;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    private static $serviceNames = [
        'Classic Haircut',
        'Fade Haircut',
        'Buzz Cut',
        'Crew Cut',
        'Pompadour',
        'Undercut',
        'Beard Trim',
        'Beard Styling',
        'Hot Towel Shave',
        'Hair Coloring',
        'Kids Haircut',
        'Senior Haircut',
    ];

    public function definition(): array
    {
        // $name = fake()->unique()->randomElement(self::$serviceNames);
        $name = $this->faker->unique()->jobTitle() . ' ' . $this->faker->word();
        $price = fake()->randomFloat(2, 50000, 250000);
        $hasDiscount = fake()->boolean(40);
        
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->paragraph(2),
            'price' => $price,
            'crossed_out_price' => $hasDiscount ? $price * 1.3 : null,
            'is_active' => fake()->boolean(90),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
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