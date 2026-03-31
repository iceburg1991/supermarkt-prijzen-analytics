<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SalesTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SalesTransaction>
 */
class SalesTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array{product_id: int, transaction_date: string, quantity: int, unit_price: float, is_promotion: bool, receipt_id: string}
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'transaction_date' => fake()->dateTimeBetween('-1 year')->format('Y-m-d'),
            'quantity' => fake()->numberBetween(1, 20),
            'unit_price' => fake()->randomFloat(2, 0.50, 25.00),
            'is_promotion' => fake()->boolean(20),
            'receipt_id' => fake()->unique()->numerify('REC-########'),
        ];
    }

    /**
     * Indicate the transaction was a promotion.
     */
    public function promotion(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_promotion' => true,
        ]);
    }
}
