<?php

namespace App\Services;

use App\Data\RevenueResult;
use App\Models\Product;
use App\Models\WeeklyRevenue;
use App\Models\WeeklyRevenueProduct;
use Illuminate\Support\Facades\Cache;

class RevenueService
{
    /**
     * Cache TTL in seconds (15 minutes).
     *
     * Revenue data is pre-aggregated and changes infrequently (typically via
     * nightly batch jobs). A 15-minute cache drastically reduces database load
     * under high traffic while keeping data reasonably fresh.
     */
    private const CACHE_TTL_SECONDS = 900;

    /**
     * Retrieve weekly revenue data for the last N weeks.
     *
     * PERFORMANCE NOTES:
     * - Uses pre-aggregated weekly_revenues table instead of querying raw
     *   sales_transactions (which could contain millions of rows).
     * - select() limits columns to reduce memory and transfer overhead.
     * - Cache stores raw arrays (not Eloquent models) to avoid serialization issues.
     * - Index on week_start ensures efficient range filtering.
     * - Returns RevenueResult DTO with timing metrics for POC demonstration.
     */
    public function getWeeklyRevenue(int $weeks = 52): RevenueResult
    {
        $cacheKey = "weekly_revenue_global_{$weeks}";
        $startTime = microtime(true);
        $cacheHit = true;

        $cached = Cache::get($cacheKey);

        if ($cached === null) {
            $cacheHit = false;
            $startDate = now()->subWeeks($weeks)->startOfWeek();

            $cached = WeeklyRevenue::query()
                ->select(['week_start', 'week_number', 'year', 'base_revenue', 'bonus_revenue'])
                ->where('week_start', '>=', $startDate)
                ->orderBy('week_start')
                ->get()
                ->toArray();

            Cache::put($cacheKey, $cached, self::CACHE_TTL_SECONDS);
        }

        $queryTimeMs = (microtime(true) - $startTime) * 1000;

        return new RevenueResult(
            data: WeeklyRevenue::hydrate($cached),
            queryTimeMs: round($queryTimeMs, 2),
            cacheHit: $cacheHit,
        );
    }

    /**
     * Retrieve weekly revenue data for a specific product for the last N weeks.
     *
     * PERFORMANCE NOTES:
     * - Uses pre-aggregated weekly_revenue_products table. In a big data scenario,
     *   calculating revenue per product from raw transactions would require
     *   expensive GROUP BY queries over millions of rows.
     * - Composite index on (product_id, week_start) ensures efficient filtering.
     * - Per-product caching isolates cache invalidation — updating one product's
     *   data doesn't invalidate the entire cache.
     * - No JOINs needed because week_number/year are denormalized on the table.
     * - Cache stores raw arrays (not Eloquent models) to avoid serialization issues.
     * - Returns RevenueResult DTO with timing metrics for POC demonstration.
     */
    public function getProductWeeklyRevenue(Product $product, int $weeks = 52): RevenueResult
    {
        $cacheKey = "weekly_revenue_product_{$product->id}_{$weeks}";
        $startTime = microtime(true);
        $cacheHit = true;

        $cached = Cache::get($cacheKey);

        if ($cached === null) {
            $cacheHit = false;
            $startDate = now()->subWeeks($weeks)->startOfWeek();

            $cached = WeeklyRevenueProduct::query()
                ->select(['week_start', 'week_number', 'year', 'base_revenue', 'bonus_revenue'])
                ->where('product_id', $product->id)
                ->where('week_start', '>=', $startDate)
                ->orderBy('week_start')
                ->get()
                ->toArray();

            Cache::put($cacheKey, $cached, self::CACHE_TTL_SECONDS);
        }

        $queryTimeMs = (microtime(true) - $startTime) * 1000;

        return new RevenueResult(
            data: WeeklyRevenueProduct::hydrate($cached),
            queryTimeMs: round($queryTimeMs, 2),
            cacheHit: $cacheHit,
        );
    }
}
