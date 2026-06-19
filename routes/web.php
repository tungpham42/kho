<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\StocktakeController;
use App\Http\Controllers\InventoryController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes (Tenant)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Master Data (Danh mục)
    Route::resource('warehouses', WarehouseController::class)->except(['create', 'show', 'edit']);
    Route::resource('partners', PartnerController::class)->except(['create', 'show', 'edit']);
    Route::resource('products', ProductController::class)->except(['create', 'show', 'edit']);

    // Transactions (Nghiệp vụ)
    Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::post('orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');

    Route::resource('transfers', StockTransferController::class)->only(['index', 'create', 'store']);
    Route::post('transfers/{transfer}/approve', [StockTransferController::class, 'approve'])->name('transfers.approve');

    Route::resource('stocktakes', StocktakeController::class)->only(['index', 'store']);
    Route::post('stocktakes/{stocktake}/approve', [StocktakeController::class, 'approve'])->name('stocktakes.approve');

    // Reports
    Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
});
