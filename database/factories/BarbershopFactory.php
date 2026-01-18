<?php

namespace Database\Factories;

use App\Models\Barbershop;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarbershopFactory extends Factory
{
    protected $model = Barbershop::class;

    public function definition(): array
    {
        $name = fake()->company() . ' Barbershop';
        
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->paragraph(3),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'google_maps_url' => 'https://maps.google.com/?q=' . urlencode(fake()->address()),
            'instagram_url' => 'https://instagram.com/' . fake()->userName(),
            'tiktok_url' => 'https://tiktok.com/@' . fake()->userName(),
            'opening_hours' => [
                'monday' => ['open' => '09:00', 'close' => '21:00'],
                'tuesday' => ['open' => '09:00', 'close' => '21:00'],
                'wednesday' => ['open' => '09:00', 'close' => '21:00'],
                'thursday' => ['open' => '09:00', 'close' => '21:00'],
                'friday' => ['open' => '09:00', 'close' => '22:00'],
                'saturday' => ['open' => '09:00', 'close' => '22:00'],
                'sunday' => ['open' => '10:00', 'close' => '20:00'],
            ],
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}