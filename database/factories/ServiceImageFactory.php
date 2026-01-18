<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceImageFactory extends Factory
{
    protected $model = ServiceImage::class;

    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'image_path' => 'services/' . fake()->uuid() . '.jpg',
            'is_primary' => false,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }

    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
            'sort_order' => 0,
        ]);
    }
}