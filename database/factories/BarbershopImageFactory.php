<?php

namespace Database\Factories;

use App\Models\Barbershop;
use App\Models\BarbershopImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarbershopImageFactory extends Factory
{
    protected $model = BarbershopImage::class;

    public function definition(): array
    {
        return [
            'barbershop_id' => Barbershop::factory(),
            'image_path' => 'barbershops/' . fake()->uuid() . '.jpg',
            'caption' => fake()->optional()->sentence(),
            'is_featured' => fake()->boolean(30), // 30% chance of being featured
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}