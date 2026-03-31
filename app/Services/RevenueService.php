<?php

namespace App\Services;

use App\Models\WeeklyRevenue;
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
}
