<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\WeeklyRevenue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeeklyRevenueProductSeeder extends Seeder
{
    /**
     * Number of random products to include per week (in addition to highlighted products).
     */
    private const RANDOM_PRODUCTS_PER_WEEK = 100;

    /**
     * Number of highlighted products that always have data for all weeks.
     */
    private const HIGHLIGHTED_PRODUCTS_COUNT = 4;

    /**
     * Seed product details for each weekly revenue record using bulk inserts.
     */
    public function run(): void
    {
        $productIds = Product::orderBy('id')->pluck('id')->toArray();
        $highlightedIds = array_slice($productIds, 0, self::HIGHLIGHTED_PRODUCTS_COUNT);
        $otherIds = array_slice($productIds, self::HIGHLIGHTED_PRODUCTS_COUNT);
        $weeklyRevenues = WeeklyRevenue::all(['id', 'week_number', 'year', 'week_start']);
        $now = now();

        $chunks = [];

        foreach ($weeklyRevenues as $weeklyRevenue) {
            // Always include highlighted products for every week
            foreach ($highlightedIds as $productId) {
                $baseRevenue = fake()->randomFloat(2, 200, 6000);
                $bonusRevenue = fake()->randomFloat(2, 50, 2000);

                $chunks[] = [
                    'weekly_revenue_id' => $weeklyRevenue->id,
                    'product_id' => $productId,
                    'week_number' => $weeklyRevenue->week_number,
                    'year' => $weeklyRevenue->year,
                    'week_start' => $weeklyRevenue->week_start,
                    'quantity' => fake()->numberBetween(50, 500),
                    'revenue_contribution' => $baseRevenue + $bonusRevenue,
                    'base_revenue' => $baseRevenue,
                    'bonus_revenue' => $bonusRevenue,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Add random selection of other products
            if (count($otherIds) > 0) {
                $sampledIds = fake()->randomElements($otherIds, min(self::RANDOM_PRODUCTS_PER_WEEK, count($otherIds)));

                foreach ($sampledIds as $productId) {
                    $baseRevenue = fake()->randomFloat(2, 200, 6000);
                    $bonusRevenue = fake()->randomFloat(2, 50, 2000);

                    $chunks[] = [
                        'weekly_revenue_id' => $weeklyRevenue->id,
                        'product_id' => $productId,
                        'week_number' => $weeklyRevenue->week_number,
                        'year' => $weeklyRevenue->year,
                        'week_start' => $weeklyRevenue->week_start,
                        'quantity' => fake()->numberBetween(50, 500),
                        'revenue_contribution' => $baseRevenue + $bonusRevenue,
                        'base_revenue' => $baseRevenue,
                        'bonus_revenue' => $bonusRevenue,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        // Bulk insert in chunks of 1000 for performance
        foreach (array_chunk($chunks, 1000) as $batch) {
            DB::table('weekly_revenue_products')->insert($batch);
        }
    }
}
