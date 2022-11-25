<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(\App\Http\Controllers\Api\ProductController::class)
    ->group(function () {
    Route::get('/products',  'index')
        ->name('products.index');

    Route::get('/products/{product:id}', 'show' )
        ->name('products.show');

    Route::post('/products', 'store' )
        ->name('products.store');

    Route::delete('/products/{product:id}', 'destroy')
        ->name('products.destroy');

    Route::put('/products/{product:id}', 'update' )
        ->name('products.update');
});

Route::controller(\App\Http\Controllers\Api\CategoryController::class)
    ->group(function () {
    Route::get('/categories',  'index')
        ->name('categories.index');

    Route::get('/categories/{category:id}', 'show' )
        ->name('categories.show');

    Route::post('/categories', 'store' )
        ->name('categories.store');

    Route::delete('/categories/{category:id}', 'destroy')
        ->name('categories.destroy');

    Route::put('/categories/{category:id}', 'update' )
        ->name('categories.update');
});


