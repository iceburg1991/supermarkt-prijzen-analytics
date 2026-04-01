<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\WeeklyRevenue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeeklyRevenueProductSeeder extends Seeder
{
    /**
     * Batch size for bulk inserts.
     *
     * Larger batches are faster but use more memory.
     * 5000 is a good balance for ~520K records.
     */
    private const BATCH_SIZE = 5000;

    /**
     * Seed product details for each weekly revenue record.
     *
     * Creates a record for EVERY product for EVERY week to demonstrate
     * big data handling capabilities. With 10K products × 52 weeks,
     * this generates ~520,000 records.
     */
    public function run(): void
    {
        $productIds = Product::orderBy('id')->pluck('id')->toArray();
        $weeklyRevenues = WeeklyRevenue::all(['id', 'week_number', 'year', 'week_start']);
        $now = now();

        $this->command->info('Generating weekly revenue data for all products...');
        $this->command->info(sprintf(
            'Products: %d × Weeks: %d = %d records',
            count($productIds),
            $weeklyRevenues->count(),
            count($productIds) * $weeklyRevenues->count()
        ));

        $batch = [];
        $totalInserted = 0;

        foreach ($weeklyRevenues as $weeklyRevenue) {
            foreach ($productIds as $productId) {
                $baseRevenue = fake()->randomFloat(2, 200, 6000);
                $bonusRevenue = fake()->randomFloat(2, 50, 2000);

                $batch[] = [
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

                // Insert in batches to manage memory
                if (count($batch) >= self::BATCH_SIZE) {
                    DB::table('weekly_revenue_products')->insert($batch);
                    $totalInserted += count($batch);
                    $this->command->info("Inserted {$totalInserted} records...");
                    $batch = [];
                }
            }
        }

        // Insert remaining records
        if (count($batch) > 0) {
            DB::table('weekly_revenue_products')->insert($batch);
            $totalInserted += count($batch);
        }

        $this->command->info("Done! Total records: {$totalInserted}");
    }
}
