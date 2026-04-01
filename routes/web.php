<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'home'])->name('dashboard.home');
Route::get('/grafiek', [DashboardController::class, 'chart'])->name('dashboard.chart');
Route::get('/products', [DashboardController::class, 'index'])->name('dashboard.index');

Route::prefix('product/{product}')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'show'])->name('show');
    Route::get('/grafiek', [ProductController::class, 'chart'])->name('chart');
    Route::get('/prijstabel', [ProductController::class, 'priceTable'])->name('priceTable');
});

Route::post('/locale/{locale}', function (Request $request, string $locale) {
    if (in_array($locale, ['nl', 'en'])) {
        $request->session()->put('locale', $locale);
    }

    return back();
})->name('locale.switch');
