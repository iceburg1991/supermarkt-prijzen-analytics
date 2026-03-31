<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'chart'])->name('dashboard.chart');
Route::get('/overzicht', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/product/{product}', [DashboardController::class, 'show'])->name('dashboard.show');
Route::get('/product/{product}/grafiek', [DashboardController::class, 'productChart'])->name('dashboard.productChart');
Route::get('/product/{product}/prijstabel', [DashboardController::class, 'priceTable'])->name('dashboard.priceTable');

Route::post('/locale/{locale}', function (Request $request, string $locale) {
    if (in_array($locale, ['nl', 'en'])) {
        $request->session()->put('locale', $locale);
    }

    return back();
})->name('locale.switch');
