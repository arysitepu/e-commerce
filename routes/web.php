<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/registrasi', [AuthController::class, 'registrasi']);
Route::post('/registrasi-save', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login-process', [AuthController::class, 'login']);
Route::get('/', [HomeController::class, 'index']);
Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'getCategory']);
    Route::get('/category/{id}', [CategoryController::class, 'getDetail']);
    Route::post('/categories/store', [CategoryController::class, 'store']);
    Route::patch('/update-category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category-delete/{id}', [CategoryController::class, 'destroy']);

    // Products
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product-detail/{id}', [ProductController::class, 'show']);
    Route::get('/products', [ProductController::class, 'getProduct']);
    Route::get('/product-create', [ProductController::class, 'create']);
    Route::post('/product-save', [ProductController::class, 'store']);
    Route::get('/product-edit/{id}', [ProductController::class, 'edit']);
    Route::patch('/product-update/{id}', [ProductController::class, 'update']);
    Route::delete('/product-delete/{id}', [ProductController::class, 'destroy']);

    // Couriers
    Route::get('/courier', [CourierController::class, 'index']);
    Route::get('/couriers', [CourierController::class, 'getCourier']);
    Route::post('/courier-save', [CourierController::class, 'store']);
    Route::get('/courier/{id}', [CourierController::class, 'show']);
    Route::patch('/update-courier/{id}', [CourierController::class, 'update']);
    Route::delete('/courier-delete/{id}', [CourierController::class, 'destroy']);

    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/users', [AuthController::class, 'getUser']);
    Route::get('/user/{id}', [AuthController::class, 'show']);
    Route::get('/user-detail/{id}', [AuthController::class, 'detail']);
    Route::post('/user-save', [AuthController::class, 'store']);
    Route::patch('/user-update/{id}', [AuthController::class, 'update']);
    Route::delete('/user-delete/{id}', [AuthController::class, 'destroy']);
    // API RAJA ONGKIR
    // Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
    // Route::get('/cities', [RajaOngkirController::class, 'getCities']);
    // Route::post('/check-ongkir', [RajaOngkirController::class, 'getCost']);
});
Route::middleware(['auth', 'role:1,2'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart-add', [CartController::class, 'addCart']);
    Route::patch('/update-qty/{id}', [CartController::class, 'updateQty']);
    Route::delete('/item-delete/{id}', [CartController::class, 'deleteItem']);
});
    
