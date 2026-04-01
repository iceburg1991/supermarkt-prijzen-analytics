<?php

namespace App\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * Data Transfer Object for revenue query results with performance metrics.
 *
 * Used to pass both the data and timing/cache information from the service
 * layer to the API resource for inclusion in the response.
 */
readonly class RevenueResult
{
    public function __construct(
        public Collection $data,
        public float $queryTimeMs,
        public bool $cacheHit,
    ) {}
}
