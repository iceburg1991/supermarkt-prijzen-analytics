<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

/**
 * POC demo controller to clear revenue cache.
 *
 * This endpoint exists purely for demonstration purposes to show
 * the performance difference between cached and uncached queries.
 * In production, cache invalidation would be handled by events
 * triggered when revenue data is updated.
 */
class CacheController extends Controller
{
    /**
     * Clear all revenue-related cache entries.
     */
    public function __invoke(): JsonResponse
    {
        // Clear global revenue cache for common week values
        foreach ([12, 26, 52, 104] as $weeks) {
            Cache::forget("weekly_revenue_global_{$weeks}");
        }

        // Clear product-specific caches (flush all matching pattern)
        // Note: This is a simplified approach for the POC.
        // In production with Redis, you'd use Cache::tags() or pattern deletion.
        Cache::flush();

        return response()->json([
            'message' => 'Revenue cache cleared',
            'cleared_at' => now()->toIso8601String(),
        ]);
    }
}
