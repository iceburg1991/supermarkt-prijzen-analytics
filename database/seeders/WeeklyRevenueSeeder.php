<?php

namespace Database\Seeders;

use App\Models\WeeklyRevenue;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WeeklyRevenueSeeder extends Seeder
{
    /**
     * Seed 52 weeks of revenue data for the past year.
     */
    public function run(): void
    {
        $start = Carbon::now()->subWeeks(51)->startOfWeek();

        for ($i = 0; $i < 52; $i++) {
            $weekStart = $start->copy()->addWeeks($i);

            WeeklyRevenue::firstOrCreate(
                [
                    'year' => (int) $weekStart->format('o'),
                    'week_number' => (int) $weekStart->format('W'),
                ],
                [
                    'week_start' => $weekStart->format('Y-m-d'),
                    'base_revenue' => fake()->randomFloat(2, 15000, 45000),
                    'bonus_revenue' => fake()->randomFloat(2, 500, 5000),
                ]
            );
        }
    }
}
