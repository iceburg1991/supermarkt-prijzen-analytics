<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\WeeklyRevenue;
use App\Models\WeeklyRevenueProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WeeklyRevenueProduct>
 */
class WeeklyRevenueProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array{weekly_revenue_id: int, product_id: int, week_number: int, year: int, quantity: int, revenue_contribution: float, base_revenue: float, bonus_revenue: float}
     */
    public function definition(): array
    {
        $weeklyRevenue = WeeklyRevenue::factory()->create();
        $baseRevenue = fake()->randomFloat(2, 1000, 50000);
        $bonusRevenue = fake()->randomFloat(2, 100, 15000);

        return [
            'weekly_revenue_id' => $weeklyRevenue->id,
            'product_id' => Product::factory(),
            'week_number' => $weeklyRevenue->week_number,
            'year' => $weeklyRevenue->year,
            'quantity' => fake()->numberBetween(10, 500),
            'revenue_contribution' => $baseRevenue + $bonusRevenue,
            'base_revenue' => $baseRevenue,
            'bonus_revenue' => $bonusRevenue,
        ];
    }
}
