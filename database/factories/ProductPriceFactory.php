<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductPrice>
 */
class ProductPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array{product_id: int, price: float, old_price: float|null, is_promotion: bool, changed_at: string}
     */
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 0.50, 15.00);

        return [
            'product_id' => Product::factory(),
            'price' => $price,
            'old_price' => fake()->optional(0.7)->randomFloat(2, 0.50, 15.00),
            'is_promotion' => fake()->boolean(20),
            'changed_at' => fake()->dateTimeBetween('-1 year')->format('Y-m-d'),
        ];
    }

    /**
     * Indicate that this price is a promotion.
     */
    public function promotion(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_promotion' => true,
        ]);
    }
}
