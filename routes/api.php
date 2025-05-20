<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoresOutletsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/checkAuth', [AuthController::class, 'checkAuth'])->middleware('auth:sanctum');


Route::get('users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('profile', [UserController::class, 'me'])->middleware('auth:sanctum');
Route::post('users', [UserController::class, 'store'])->middleware('auth:sanctum');
Route::get('users/{id}', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::patch('users/{id}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/stores', [StoresOutletsController::class, 'index'])->middleware('auth:sanctum');
Route::post('/stores', [StoresOutletsController::class, 'store'])->middleware('auth:sanctum');
Route::get('/stores/{id}', [StoresOutletsController::class, 'show'])->middleware('auth:sanctum');
Route::patch('/stores/{id}', [StoresOutletsController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/stores/{id}', [StoresOutletsController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::get('/categoryCount', [CategoryController::class, 'countCategory'])->middleware('auth:sanctum');
Route::post('/categories', [CategoryController::class, 'store'])->middleware('auth:sanctum');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->middleware('auth:sanctum');
Route::patch('/categories/{id}', [CategoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/transaction_types', [TransactionTypeController::class, 'index'])->middleware('auth:sanctum');
Route::get('/transactionsTop4', [TransactionController::class, 'getTopFour'])->middleware('auth:sanctum');
Route::post('/transaction_types', [TransactionTypeController::class, 'store'])->middleware('auth:sanctum');
Route::get('/transaction_types/{id}', [TransactionTypeController::class, 'show'])->middleware('auth:sanctum');
Route::patch('/transaction_types/{id}', [TransactionTypeController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/transaction_types/{id}', [TransactionTypeController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/transactions', [TransactionController::class, 'index'])->middleware('auth:sanctum');
Route::get('/transactionsMonthly', [TransactionController::class, 'getMonthlyReport'])->middleware('auth:sanctum');
Route::post('/transactions', [TransactionController::class, 'store'])->middleware('auth:sanctum');
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->middleware('auth:sanctum');
Route::get('/transactions/type/{type}', [TransactionController::class, 'indexByType'])->middleware('auth:sanctum');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index'])->middleware('auth:sanctum');
Route::get('/productStocks', [ProductController::class, 'getAllStocks'])->middleware('auth:sanctum');
Route::get('/productLowStocks', [ProductController::class, 'getAllLowStock'])->middleware('auth:sanctum');
Route::get('/productOutofStocks', [ProductController::class, 'getAllOutOfStock'])->middleware('auth:sanctum'); 
Route::post('/products', [ProductController::class, 'store'])->middleware('auth:sanctum');
Route::get('/products/{id}', [ProductController::class, 'show'])->middleware('auth:sanctum');
Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('search/products/{search}', [ProductController::class, 'searchProduct'])->middleware('auth:sanctum');


Route::get('/products/category/{category_id}', [ProductController::class, 'showByCategory'])->middleware('auth:sanctum'); // New route
Route::get('/products/price', [ProductController::class, 'showByPrice'])->middleware('auth:sanctum');