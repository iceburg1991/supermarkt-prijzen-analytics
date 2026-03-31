<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\WeeklyRevenue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeeklyRevenueProductSeeder extends Seeder
{
    /**
     * Number of products to include per week.
     */
    private const PRODUCTS_PER_WEEK = 1000;

    /**
     * Seed product details for each weekly revenue record using bulk inserts.
     */
    public function run(): void
    {
        $productIds = Product::pluck('id')->toArray();
        $weeklyRevenues = WeeklyRevenue::all(['id', 'week_number', 'year']);
        $now = now();

        $chunks = [];

        foreach ($weeklyRevenues as $weeklyRevenue) {
            $sampledIds = fake()->randomElements($productIds, min(self::PRODUCTS_PER_WEEK, count($productIds)));

            foreach ($sampledIds as $productId) {
                $chunks[] = [
                    'weekly_revenue_id' => $weeklyRevenue->id,
                    'product_id' => $productId,
                    'week_number' => $weeklyRevenue->week_number,
                    'year' => $weeklyRevenue->year,
                    'quantity' => fake()->numberBetween(50, 500),
                    'revenue_contribution' => fake()->randomFloat(2, 200, 8000),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Bulk insert in chunks of 1000 for performance
        foreach (array_chunk($chunks, 1000) as $batch) {
            DB::table('weekly_revenue_products')->insert($batch);
        }
    }
}
