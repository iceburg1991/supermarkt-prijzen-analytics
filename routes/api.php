<?php

use App\Http\Controllers\Api\RevenueController;
use Illuminate\Support\Facades\Route;

Route::get('/revenue', [RevenueController::class, 'index']);
Route::get('/revenue/product/{product}', [RevenueController::class, 'show']);
