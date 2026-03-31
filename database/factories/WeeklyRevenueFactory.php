<?php

namespace Database\Factories;

use App\Models\WeeklyRevenue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WeeklyRevenue>
 */
class WeeklyRevenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array{week_start: string, week_number: int, year: int, base_revenue: float, bonus_revenue: float}
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-1 year');
        $weekNumber = (int) $date->format('W');
        $year = (int) $date->format('o');

        return [
            'week_start' => (new \DateTimeImmutable)->setISODate($year, $weekNumber, 1)->format('Y-m-d'),
            'week_number' => $weekNumber,
            'year' => $year,
            'base_revenue' => fake()->randomFloat(2, 1000000, 3000000),
            'bonus_revenue' => fake()->randomFloat(2, 100000, 1500000),
        ];
    }
}
