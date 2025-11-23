<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuotationController;

// ===== Category Routes =====
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);       // List all categories
    Route::post('/', [CategoryController::class, 'store']);      // Create category
    Route::get('/{id}', [CategoryController::class, 'show']);    // Show single category
    Route::put('/{id}', [CategoryController::class, 'update']);  // Update category
    Route::delete('/{id}', [CategoryController::class, 'destroy']); // Delete category
});

// ===== Quotation Routes =====
Route::prefix('quotations')->group(function () {
    Route::get('/', [QuotationController::class, 'index']);
    Route::post('/', [QuotationController::class, 'store']);
    Route::get('/{id}', [QuotationController::class, 'show']);
    Route::put('/{id}', [QuotationController::class, 'update']);
    Route::delete('/{id}', [QuotationController::class, 'destroy']);
    Route::post('/bulk', [QuotationController::class, 'bulkAdd']);

});
