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
        $prices = $product->productPrices()
            ->select(['price', 'changed_at'])
            ->orderBy('changed_at')
            ->get();

        return new PriceHistoryResource($prices);
    }
}
