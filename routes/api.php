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
Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register');

Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');

Route::middleware('auth')->get('/user', function (Request $request) {
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
})->middleware('auth');

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
})->middleware('auth');

Route::controller(\App\Http\Controllers\Api\UserController::class)
    ->group(function () {
        Route::get('/users',  'index')
            ->name('users.index');

        Route::get('/users/{user:id}', 'show' )
            ->name('users.show');

        Route::post('/users', 'store' )
            ->name('users.store');

        Route::delete('/users/{user:id}', 'destroy')
            ->name('users.destroy');

        Route::put('/users/{user:id}', 'update' )
            ->name('users.update');
    }
)->middleware('auth');

Route::controller(\App\Http\Controllers\Api\ProductUserController::class)
    ->group(function () {
        Route::get('/product_user',  'index')
            ->name('users.index');

        Route::get('/product_user/{product_user:id}', 'show' )
            ->name('users.show');

        Route::post('/product_user', 'store' )
            ->name('users.store');

        Route::delete('/product_user/{product_user:id}', 'destroy')
            ->name('users.destroy');

        Route::put('/product_user/{product_user:id}', 'update' )
            ->name('users.update');
    }
)->middleware('auth');

Route::controller(\App\Http\Controllers\Api\OrderController::class)
    ->group(function () {
        Route::get('/orders',  'index')
            ->name('orders.index');

        Route::get('/orders/{order:id}', 'show' )
            ->name('orders.show');

        Route::post('/orders', 'store' )
            ->name('orders.store');

        Route::delete('/orders/{order:id}', 'destroy')
            ->name('orders.destroy');

        Route::put('/orders/{order:id}', 'update' )
            ->name('orders.update');
    }
)->middleware('auth');



