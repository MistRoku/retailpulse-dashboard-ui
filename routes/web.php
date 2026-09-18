<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LegalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. THE ROOT ROUTE (Must be first)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. PRODUCT CATALOG
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 3. STAFF MANAGEMENT
Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');

// 4. POINT OF SALE
Route::get('/pos', [PosController::class, 'terminal'])->name('pos.terminal');

// 5. REPORTS
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

// 6. SETTINGS
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

// 7. LEGAL PAGES
Route::prefix('legal')->group(function () {
    Route::get('/terms', [LegalController::class, 'terms'])->name('legal.terms');
    Route::get('/privacy', [LegalController::class, 'privacy'])->name('legal.privacy');
});
