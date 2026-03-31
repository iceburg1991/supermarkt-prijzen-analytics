<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard overview page.
     */
    public function index(): View
    {
        $products = Product::orderBy('id')->paginate(25);

        return view('dashboard.index', compact('products'));
    }

    /**
     * Display the chart page.
     */
    public function chart(): View
    {
        return view('dashboard.chart');
    }
}
