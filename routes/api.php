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
Route::get('/users', [AuthController::class, 'register']);

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::patch('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);

Route::get('/stores', [StoresOutletsController::class, 'index']);
Route::post('/stores', [StoresOutletsController::class, 'store']);
Route::get('/stores/{id}', [StoresOutletsController::class, 'show']);
Route::put('/stores/{id}', [StoresOutletsController::class, 'update']);
Route::delete('/stores/{id}', [StoresOutletsController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::patch('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::get('/transaction_types', [TransactionTypeController::class, 'index']);
Route::post('/transaction_types', [TransactionTypeController::class, 'store']);
Route::get('/transaction_types/{id}', [TransactionTypeController::class, 'show']);
Route::patch('/transaction_types/{id}', [TransactionTypeController::class, 'update']);
Route::delete('/transaction_types/{id}', [TransactionTypeController::class, 'destroy']);

Route::get('/transactions', [TransactionController::class, 'index']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::get('/transactions/{id}', [TransactionController::class, 'show']);
Route::put('/transactions/{id}', [TransactionController::class, 'update']);
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/category/{category_id}', [ProductController::class, 'showByCategory']);
Route::get('/products/price', [ProductController::class, 'showByPriceDesc']);
Route::get('/products/price', [ProductController::class, 'showByPriceAsc']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
