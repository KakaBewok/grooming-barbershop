<?php

namespace Database\Factories;

use App\Models\Barbershop;
use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'barbershop_id' => Barbershop::factory(),
            'order_number' => Order::generateOrderNumber(),
            'order_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'total_amount' => 0, // Will be calculated from order items
            'discount' => fake()->boolean(30) ? fake()->randomFloat(2, 5000, 50000) : 0,
            'payment_method' => fake()->randomElement(PaymentMethod::cases()),
            'status' => fake()->randomElement(OrderStatus::cases()),
            'notes' => fake()->optional()->sentence(),
            'created_by' => User::factory(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::PENDING,
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::PAID,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::COMPLETED,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::CANCELLED,
        ]);
    }

    public function cash(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => PaymentMethod::CASH,
        ]);
    }

    public function transfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => PaymentMethod::TRANSFER,
        ]);
    }

    public function qris(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => PaymentMethod::QRIS,
        ]);
    }
}