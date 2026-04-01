<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the product detail page.
     */
    public function show(Product $product): View
    {
        return view('product.show', [
            'product' => $product,
            'locale' => app()->getLocale(),
        ]);
    }

    /**
     * Display the product chart page.
     */
    public function chart(Product $product): View
    {
        return view('product.chart', compact('product'));
    }

    /**
     * Display the product price table page.
     */
    public function priceTable(Product $product): View
    {
        $prices = $product->productPrices()
            ->orderByDesc('changed_at')
            ->paginate(25);

        return view('product.price-table', compact('product', 'prices'));
    }
}
