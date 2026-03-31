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
        $products = Product::all();

        return view('dashboard.index', compact('products'));
    }
}
