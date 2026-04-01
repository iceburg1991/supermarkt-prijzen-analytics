<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriceHistoryResource;
use App\Models\Product;

class PriceController extends Controller
{
    /**
     * Return price history for a product in Highcharts-compatible format.
     */
    public function index(Product $product): PriceHistoryResource
    {
        // Important for performance;
        // - I'm using a select
        // - Limiting the total data set (with the changed_at )
        $prices = $product->productPrices()
            ->select(['price', 'changed_at'])
            ->where('changed_at', '>=', now()->subYears(2)) // max 2 years
            ->orderBy('changed_at')
            ->get();

        return new PriceHistoryResource($prices);
    }
}
