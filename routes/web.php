<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'chart'])->name('dashboard.chart');
Route::get('/overzicht', [DashboardController::class, 'index'])->name('dashboard.index');
