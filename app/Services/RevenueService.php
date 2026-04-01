<?php

namespace App\Services;

use App\Models\Product;
use App\Models\WeeklyRevenue;
use App\Models\WeeklyRevenueProduct;
use Illuminate\Database\Eloquent\Collection;

class RevenueService
{
    /**
     * Retrieve weekly revenue data for the last N weeks.
     *
     * @return Collection<int, WeeklyRevenue>
     */
    public function getWeeklyRevenue(int $weeks = 52): Collection
    {
        $startDate = now()->subWeeks($weeks)->startOfWeek();

        return WeeklyRevenue::query()
            ->select(['week_start', 'week_number', 'year', 'base_revenue', 'bonus_revenue'])
            ->where('week_start', '>=', $startDate)
            ->orderBy('week_start')
            ->get();
    }

    /**
     * Retrieve weekly revenue data for a specific product for the last N weeks.
     *
     * @return Collection<int, WeeklyRevenueProduct>
     */
    public function getProductWeeklyRevenue(Product $product, int $weeks = 52): Collection
    {
        $startDate = now()->subWeeks($weeks)->startOfWeek();

        //Important to explain for the POC; big data sets require AGGREGATED data,
        //so we do NOT use foreach loops or joins
        return WeeklyRevenueProduct::query()
            ->select(['week_start', 'week_number', 'year', 'base_revenue', 'bonus_revenue'])
            ->where('product_id', $product->id)
            ->where('week_start', '>=', $startDate)
            ->orderBy('week_start')
            ->get();
    }
}
