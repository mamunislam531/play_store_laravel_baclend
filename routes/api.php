<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\FavoriteQuotationController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthorQuoteController;
use App\Http\Controllers\NamesListController;



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

Route::get('/slider', [QuotationController::class, 'slider']);


// ===== favorites Routes =====
Route::prefix('favorites')->group(function () {
    Route::post('/', [FavoriteQuotationController::class, 'store']);
    Route::get('/{device_id}', [FavoriteQuotationController::class, 'index']);
    Route::delete('/', [FavoriteQuotationController::class, 'destroy']);
});

// Full CRUD routes for authors
Route::apiResource('authors', AuthorController::class);




Route::apiResource('author-quotes', AuthorQuoteController::class);
Route::post('author-quotes/bulk', [AuthorQuoteController::class, 'bulkAdd']);
// Get all quotes by specific author
Route::get('authors/{id}/quotes', function ($id) {
    return \App\Models\AuthorQuote::where('author_id', $id)->get();
});

use App\Http\Controllers\FavAuthorQuoteController;

Route::get('fav-author-quote', [FavAuthorQuoteController::class, 'index']);
Route::post('fav-author-quote', [FavAuthorQuoteController::class, 'store']);
Route::delete('fav-author-quote', [FavAuthorQuoteController::class, 'destroy']);
Route::get('/quote-slider', [FavAuthorQuoteController::class, 'slider']);

use App\Http\Controllers\ReligionController;

Route::apiResource('religions', ReligionController::class);


Route::prefix('names')->group(function () {
    Route::get('/', [NamesListController::class, 'index']);
    Route::post('/', [NamesListController::class, 'store']);
    Route::get('/religion/{id}', [NamesListController::class, 'byReligion']);
    Route::get('/religion/{id}/{gender}', [NamesListController::class, 'byReligionAndGender']);
    Route::post('/bulk', [NamesListController::class, 'bulkStore']);
});


// routes/api.php
use App\Http\Controllers\NameSliderAppController;

Route::get('/name-app-slider', [NameSliderAppController::class, 'index']);
Route::post('/name-app-slider', [NameSliderAppController::class, 'store']);
Route::delete('/name-app-slider/{slider}', [NameSliderAppController::class, 'destroy']);
