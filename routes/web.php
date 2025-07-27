<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'index']);
Route::get('/', [HomeController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'getCategory']);
    Route::get('/category/{id}', [CategoryController::class, 'getDetail']);
    Route::post('/categories/store', [CategoryController::class, 'store']);
    Route::patch('/update-category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category-delete/{id}', [CategoryController::class, 'destroy']);

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('admin.products.update');
    Route::get('/products/{id}/delete', [ProductController::class, 'destroy'])->name('admin.products.delete');

    // Couriers
    Route::get('/couriers', [CourierController::class, 'index'])->name('admin.couriers.index');
    Route::get('/couriers/create', [CourierController::class, 'create'])->name('admin.couriers.create');
    Route::post('/couriers/store', [CourierController::class, 'store'])->name('admin.couriers.store');
    Route::get('/couriers/{id}/edit', [CourierController::class, 'edit'])->name('admin.couriers.edit');
    Route::post('/couriers/{id}/update', [CourierController::class, 'update'])->name('admin.couriers.update');
    Route::get('/couriers/{id}/delete', [CourierController::class, 'destroy'])->name('admin.couriers.delete');
