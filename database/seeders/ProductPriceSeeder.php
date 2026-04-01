<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPriceSeeder extends Seeder
{
    /**
     * Seed product price history using a random walk approach.
     *
     * Each product gets 52 weeks of price mutations where consecutive
     * prices never deviate more than 10% from each other. This produces
     * realistic, smooth price curves suitable for charting.
     *
     * Uses chunked bulk inserts for big data performance.
     */
    public function run(): void
    {
        $weeks = 52;
        $promotionChance = 0.15;
        $maxDeviation = 0.10;
        $chunkSize = 2000;
        $buffer = [];
        $now = now();

        Product::query()
            ->select('id')
            ->chunkById(500, function ($products) use (
                $weeks,
                $promotionChance,
                $maxDeviation,
                $chunkSize,
                &$buffer,
                $now,
            ) {
                foreach ($products as $product) {
                    // Start with a random base price between €0.80 and €12.00
                    $currentPrice = round(random_int(80, 1200) / 100, 2);
                    $startDate = $now->copy()->subWeeks($weeks - 1)->startOfWeek();

                    for ($w = 0; $w < $weeks; $w++) {
                        $changedAt = $startDate->copy()->addWeeks($w);
                        $isPromotion = random_int(1, 100) <= ($promotionChance * 100);

                        // Calculate new price within ±10% of current price
                        $minPrice = round($currentPrice * (1 - $maxDeviation), 2);
                        $maxPrice = round($currentPrice * (1 + $maxDeviation), 2);
                        $newPrice = round(random_int((int) ($minPrice * 100), (int) ($maxPrice * 100)) / 100, 2);

                        // Ensure price stays above €0.10
                        $newPrice = max(0.10, $newPrice);

                        $buffer[] = [
                            'product_id' => $product->id,
                            'price' => $newPrice,
                            'old_price' => $w === 0 ? null : $currentPrice,
                            'is_promotion' => $isPromotion,
                            'changed_at' => $changedAt->format('Y-m-d'),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];

                        $currentPrice = $newPrice;

                        // Flush buffer in chunks for memory efficiency
                        if (count($buffer) >= $chunkSize) {
                            DB::table('product_prices')->insert($buffer);
                            $buffer = [];
                        }
                    }
                }
            });

        // Flush remaining records
        if (! empty($buffer)) {
            DB::table('product_prices')->insert($buffer);
        }
    }
}
