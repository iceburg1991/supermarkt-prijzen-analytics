<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        return view('dashboard.home');
    }

    /**
     * Display the dashboard overview page.
     */
    public function index(): View
    {
        $highlightedProducts = Product::orderBy('id')->take(4)->get();
        $products = Product::orderBy('id')->paginate(25);

        return view('dashboard.index', compact('highlightedProducts', 'products'));
    }

    /**
     * Display the chart page with locale for Highcharts localization.
     */
    public function chart(): View
    {
        return view('dashboard.chart', [
            'locale' => app()->getLocale(),
        ]);
    }

    /**
     * Display the product detail page.
     */
    public function show(Product $product): View
    {
        return view('dashboard.show', compact('product'));
    }

    /**
     * Display the product chart page.
     */
    public function productChart(Product $product): View
    {
        return view('dashboard.product-chart', compact('product'));
    }

    /**
     * Display the product price table page.
     */
    public function priceTable(Product $product): View
    {
        $prices = $product->productPrices()
            ->orderByDesc('changed_at')
            ->paginate(25);

        return view('dashboard.price-table', compact('product', 'prices'));
    }
}
